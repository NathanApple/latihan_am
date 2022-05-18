<?php

namespace App\Http\Controllers;

use App\Models\UserFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str;

class UserFileController extends Controller
{
    //
    public function store(Request $request){
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['user_not_found'], 404);
        }
        $validator = Validator::make($request->all(), [
            'file_category_id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $file = $request->file('file'); 
        
        // $currTime = Carbon::now();
        $fileName = Str::orderedUuid().'.'.$file->getClientOriginalExtension();
        $file->move('upload/userfile/', $fileName);

        
        $userfile = UserFile::updateOrCreate(
            [
                'user_id' => $user["id"],
                'file_category_id' => $request->get('file_category_id'), 
            ],
            [
                'file_url' => 'upload/userfile/'.$fileName,
            ]
        );

        return response()->json(compact('userfile'),201);
    }
}
