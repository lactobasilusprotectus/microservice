<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MentorController extends Controller
{
    public function index(){
        $mentor = Mentor::all();
        return response()->json([
           'status' => 'success',
           'data' => $mentor
        ]);
    }

    public function show($id){
        $mentor = Mentor::find($id);

        if (!$mentor){
            return response()->json([
                'status' => 'error',
                'message' => 'mentor not found'
            ], 404);
        }
        else {
            return response()->json([
                'status' => 'success',
                'data' => $mentor
            ]);
        }
    }

    public function create(Request $request){
        $rule = [
            'name' => ['required', 'string'],
            'profile' => ['required', 'url'],
            'profession' => ['required', 'string'],
            'email' => ['required', 'email']
        ];

        $data = $request->all();

        $validate = Validator::make($data, $rule);

        if ($validate->fails()){
            return response()->json([
               'status' => 'error',
               'message' => $validate->errors()
            ], 400);
        }

        $mentor = Mentor::create($data);

        return response()->json([
           'status' => 'success',
           'data' => $mentor
        ]);
    }

    public function update(Request $request, $id){
        $rule = [
            'name' => ['string'],
            'profile' => ['url'],
            'profession' => ['string'],
            'email' => ['email']
        ];

        $data = $request->all();

        $validate = Validator::make($data, $rule);

        if ($validate->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validate->errors()
            ], 400);
        }

        $mentor = Mentor::find($id);

        if (!$mentor){
            return response()->json([
                'status' => 'error',
                'message' => 'mentor not found'
            ], 404);
        }else {
            $mentor->update($data);
            return response()->json([
                'status' => 'success',
               'data' => $mentor
            ]);
        }
    }

    public function delete($id){
        $mentor = Mentor::find($id);

        if (!$mentor){
            return response()->json([
                'status' => 'error',
                'message' => 'mentor not found'
            ], 404);
        }else {
            $mentor->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'mentor deleted'
            ]);
        }
    }
}
