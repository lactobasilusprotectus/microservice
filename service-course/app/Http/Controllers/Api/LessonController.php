<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LessonController extends Controller
{
    public function index(Request $request){
        $lesson = Lesson::query();

        $chapter_id = $request->query('chapter_id');

        $lesson->when($chapter_id, function ($query) use ($chapter_id) {
           return $query->where('chapters_id', $chapter_id);
        });

        return response()->json([
            'status' => 'success',
            'data' => $lesson->get()
        ]);
    }

    public function show($id){
        $lesson = Lesson::find($id);

        if (!$lesson){
            return response()->json([
                'status' => 'error',
                'message' => 'lesson not found'
            ]);
        }

        return response()->json([
            'status' => 'success',
            'data' => $lesson
        ]);

    }

    public function create(Request $request){

        $rule = [
            'name' => ['required', 'string'],
            'video' => ['required', 'string'],
            'chapters_id' => ['required', 'integer']
        ];

        $data = $request->all();

        $validate = Validator::make($data, $rule);

        if ($validate->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validate->errors()
            ], 400);
        }

        $chapter = Chapter::find($data['chapters_id']);

        if (!$chapter){
            return response()->json([
                'status' => 'error',
                'message' => "chapter not found"
            ], 404);
        }

        $lesson = Lesson::create($data);

        return response()->json([
            'status' => 'success',
            'data' => $lesson
        ]);
    }

    public function update(Request $request, $id){
        $rule = [
            'name' => ['string'],
            'video' => ['string'],
            'chapters_id' => ['integer']
        ];

        $data = $request->all();

        $validate = Validator::make($data, $rule);

        if ($validate->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validate->errors()
            ], 400);
        }

        $lesson = Lesson::find($id);

        if (!$lesson){
            return response()->json([
                'status' => 'error',
                'message' => 'lesson not found'
            ], 404);
        }

        $chapter_id = $data['chapters_id'];
        if ($chapter_id){
            $chapter = Chapter::find($chapter_id);
            if (!$chapter){
                return response()->json([
                    'status' => 'error',
                    'message' => 'chapter not found'
                ], 404);
            }else{
                $lesson->update($data);
                return response()->json([
                    'status' => 'success',
                    'data' => $lesson
                ]);
            }
        }
    }

    public function delete($id){
        $lesson = Lesson::find($id);

        if (!$lesson){
            return response()->json([
                'status' => 'error',
                'message' => 'lesson not found'
            ], 404);
        }

        $lesson->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'lesson deleted'
        ]);
    }
}
