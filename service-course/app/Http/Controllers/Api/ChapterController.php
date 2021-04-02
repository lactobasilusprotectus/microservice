<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChapterController extends Controller
{
    public function index(Request $request){
        $chapter = Chapter::query();

        $course_id = $request->query('course_id');

        $chapter->when($course_id, function ($query) use ($course_id){
           return $query->where('courses_id', $course_id);
        });

        return response()->json([
           'status' => 'success',
           'data' => $chapter->get()
        ]);
    }

    public function create(Request $request){
        $rule = [
          'name' => ['required', 'string'],
          'courses_id' => ['required', 'integer']
        ];

        $data = $request->all();

        $validate = Validator::make($data, $rule);

        if ($validate->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validate->errors()
            ], 400);
        }

        $course_id = $data['courses_id'];
        $course = Course::find($course_id);

        if (!$course){
            return response()->json([
                'status' => 'error',
                'message' => "course not found"
            ], 404);
        }

        $chapter = Chapter::create($data);

        return response()->json([
            'status' => 'success',
            'data' => $chapter
        ]);
    }

    public function update(Request $request, $id){
        $rule = [
            'name' => ['string'],
            'courses_id' => ['integer']
        ];

        $data = $request->all();

        $validate = Validator::make($data, $rule);

        if ($validate->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validate->errors()
            ], 400);
        }

        $chapter = Chapter::find($id);

        if (!$chapter){
            return response()->json([
                'status' => 'error',
                'message' => "chapter not found"
            ], 404);
        }

        if ($request->courses_id){
            $course_id = $request->courses_id;
            if ($course_id){
                $course = Course::find($course_id);
                if (!$course){
                    return response()->json([
                        'status' => 'error',
                        'message' => "course not found"
                    ], 404);
                }
            }
        }

        $chapter->update($data);
        return response()->json([
            'status' => 'success',
            'data' => $chapter
        ]);
    }

    public function show($id){
        $chapter = Chapter::find($id);

        if (!$chapter){
            return response()->json([
                'status' => 'error',
                'message' => 'chapter not found'
            ], 404);
        }
        else {
            return response()->json([
                'status' => 'success',
                'data' => $chapter
            ]);
        }
    }

    public function delete($id){
        $chapter = Chapter::find($id);

        if (!$chapter){
            return response()->json([
                'status' => 'error',
                'message' => 'chapter not found'
            ], 404);
        }
        else {
            return response()->json([
                'status' => 'success',
                'message' => 'chapter deleted'
            ]);
        }
    }
}
