<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\MyCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MyCourseController extends Controller
{
    public function index(Request $request)
    {
        $myCourse = MyCourse::query()->with('courses');

        $userId = $request->query('user_id');

        $myCourse->when($userId, function($q) use ($userId)
        {
            $q->where('user_id', '=', $userId);
        });

        return response()->json([
            'status' => 'success',
            'data' => $myCourse->get()
        ]);
    }

    public function create(Request $request)
    {
        $rules = [
            'courses_id' => ['required', 'integer'],
            'user_id' => ['required', 'integer'],
        ];

        $validate = Validator::make($request->all(), $rules);

        if ($validate->fails())
        {
            return response()->json([
                'status' => 'error',
                'message' => $validate->errors()
            ], 400);
        }

        $courseId = $request->courses_id;

        $course = Course::find($courseId);

        if (!$course)
        {
            return  response()->json([
                'status' => 'error',
                'message' => 'course not found'
            ], 404);
        }

        $userId = $request->user_id;

        $user = getUser($userId);

        if ($user['status'] === 'error')
        {
            return response()->json([
               'status' => $user['status'],
               'message' => $user['message']
            ], $user['http_code']);
        }

        $ifExist = MyCourse::whereCoursesId($courseId)->where('user_id', $userId)->exists();

        if ($ifExist)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'user already taken this course'
            ], 400);
        }

        $myCourse = MyCourse::create($request->all());

        return response()->json([
           'status' => 'success',
           'data' => $myCourse
        ]);

    }

}
