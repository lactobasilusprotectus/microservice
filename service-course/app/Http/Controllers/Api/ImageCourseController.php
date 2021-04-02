<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\ImageCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ImageCourseController extends Controller
{
    public function create(Request $request){

        $rule = [
            'image' => ['required', 'url'],
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

        $course = Course::find($data['courses_id']);

        if (!$course){
            return response()->json([
                'status' => 'error',
                'message' => 'course not found'
            ], 404);
        }

        $image = ImageCourse::create($data);

        return response()->json([
            'status' => 'success',
            'data' => $image
        ]);

    }

    public function delete($id){
        $image = ImageCourse::find($id);

        if (!$image){
            return response()->json([
                'status' => 'error',
                'message' => 'image not found'
            ], 404);
        }

        $image->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'image deleted'
        ]);
    }
}
