<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Course;
use App\Models\Mentor;
use App\Models\MyCourse;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    public function index(Request $request){
        $course = Course::query();

        $q = $request->query('q');
        $status = $request->query('status');

        $course->when($q, function ($query) use ($q){
           return $query->whereRaw("name LIKE '%". strtolower($q). "%'");
        });

        $course->when($status, function ($query) use ($status){
            return $query->where('status', $status);
        });

        return response()->json([
           'status' => 'success',
           'data' => $course->paginate(10)
        ]);
    }

    public function show($id)
    {
        $course = Course::with('mentor', 'chapters.lessons', 'images')->find($id);

        if (!$course)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'course not found'
            ], 404);
        }

        $reviews = Review::whereCoursesId($id)->get()->toArray();

        if (count($reviews) > 0)
        {
            $user_ids = array_column($reviews, 'user_id');

            $users = getUserById($user_ids);

            if ($users['status'] === 'error')
            {
                $reviews = [];
            }else{
                foreach ($reviews as $key => $review)
                {
                    $userIndex = array_search($review['user_id'], array_column($users['data'], 'id'));

                    $reviews[$key]['users'] = $users['data'][$userIndex];
                }
            }
        }

        $totalStudents = MyCourse::whereCoursesId($id)->count();

        $totalVideos = Chapter::whereCoursesId($id)->withCount('lessons')->get()->toArray();

        $fixTotal = array_sum(array_column($totalVideos, 'lessons_count'));

        $course['reviews'] = $reviews;

        $course['total_videos'] = $fixTotal;

        $course['total_students'] = $totalStudents;

        return response()->json([
            'status' => 'success',
            'data' => $course
        ]);
    }

    public function create(Request $request){
        $rule = [
            'name' => ['string', 'required'],
            'certificate' => ['required', 'boolean'],
            'thumbnail' => ['string', 'url'],
            'type' => ['required', 'in:free, premium'],
            'status' => ['required', 'in:draft, published'],
            'price' => ['integer'],
            'level' => ['required', 'in:all-level, beginner, intermediate, advance'],
            'mentors_id' => ['required', 'integer'],
            'description' => ['string']
        ];

        $data = $request->all();

        $validate = Validator::make($data, $rule);
        if ($validate->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validate->errors()
            ], 400);
        }

        $mentor_id = $data['mentors_id'];
        $mentor = Mentor::find($mentor_id);

        if (!$mentor){
            return response()->json([
                'status' => 'error',
                'message' => 'mentor not found'
            ], 404);
        }

        $course = Course::create($data);
        return response()->json([
           'status' => 'success',
           'data' => $course
        ]);
    }

    public function update(Request $request, $id){
        $rule = [
            'name' => ['string'],
            'certificate' => ['boolean'],
            'thumbnail' => ['string', 'url'],
            'type' => ['in:free, premium'],
            'status' => ['in:draft, published'],
            'price' => ['integer'],
            'level' => ['in:all-level, beginner, intermediate, advance'],
            'mentors_id' => ['integer'],
            'description' => ['string']
        ];

        $data = $request->all();

        $validate = Validator::make($data, $rule);
        if ($validate->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validate->errors()
            ], 400);
        }

        $course = Course::find($id);
        if (!$course){
            return response()->json([
                'status' => 'error',
                'message' => "course not found"
            ], 404);
        }

         if ($request->mentors_id){
             $mentor_id = $request->mentors_id;
             if ($mentor_id){
                 $mentor = Mentor::find($mentor_id);
                 if (!$mentor){
                     return response()->json([
                         'status' => 'error',
                         'message' => 'mentor not found'
                     ], 404);
                 }
             }
         }

        $course->update($data);

        return response()->json([
            'status' => 'success',
            'data' => $course
        ]);
    }

    public function delete($id){
        $course = Course::find($id);

        if (!$course){
            return response()->json([
                'status' => 'error',
                'message' => "course not found"
            ], 404);
        }

        $course->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'course deleted'
        ]);
    }
}
