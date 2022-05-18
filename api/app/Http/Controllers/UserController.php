<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class UserController extends Controller
{

    public function emailAvailability(Request $request){
        // Return email status
        // True if available, False is not available
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255|unique:users',
        ]);

        if($validator->fails()){
            return response()->json(['status' => 'false', 'message' => $validator->errors()], 200);
        } else {
            return response()->json(['status' => 'true', 'message' => 'email is available'], 200);

        }

    }

    public function view(Request $request){
        $users = User::query()
                    ->select('id', 'image_url', 'username');

        if(!empty($request->get("approval"))){
            $users->where("approval", $request->get("approval"));
        }

        $users  = $users->get();
        return response()->json(compact('users'),201);


    }

    public function detail(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $users = User::with(
                    "user_files", 
                    "user_files.file_categories:id,name,image_url", 
                    "universities")
                    ->where('users.id', $request->get('id'));

        $users  = $users->get();
        return response()->json(compact('users'),201);
    }

    public function approval(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'approval' => ['required', Rule::in(['Pending', 'Approved', 'Rejected'])],
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $users = User::find($request->get('id'))
                    ->update(["approval" => $request->get('approval')]);
        
        return response()->json(compact('users'),201);


    }


}
