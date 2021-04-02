<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    public function create(Request $request)
    {
        $rules = [
            'user_id' => ['required', 'integer'],
            'courses_id' => ['required', 'integer'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'note' => ['string']
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

        $ifReviewExist = Review::whereCoursesId($courseId)->where('user_id', $userId)->exists();

        if ($ifReviewExist)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'review already exist'
            ], 400);
        }

        $review = Review::create($request->all());

        return response()->json([
            'status' => 'success',
            'data' => $review
        ]);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'rating' => ['integer', 'min:1', 'max:5'],
            'note' => ['string']
        ];

        $data = $request->except('user_id', 'courses_id');

        $validate = Validator::make($request->all(), $rules);

        if ($validate->fails())
        {
            return response()->json([
                'status' => 'error',
                'message' => $validate->errors()
            ], 400);
        }

        $review = Review::find($id);

        if (!$review)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'review not found'
            ], 404);
        }

        $review->update($data);

        return response()->json([
            'status' => 'success',
            'message' => $review
        ]);
    }

    public function delete($id)
    {
        $review = Review::find($id);

        if (!$review)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'review not found'
            ], 404);
        }

        $review->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'review deleted'
        ]);
    }
}
