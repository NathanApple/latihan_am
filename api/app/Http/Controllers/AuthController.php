<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserFile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Illuminate\Support\Str;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        # Login : Menggunakan JWTAuth::attempt("email", "password")
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'university_id' => 'required',
            'phone' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
            'username' => $request->get('username'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'university_id' => $request->get('university_id'),
            'phone' => $request->get('phone'),
            'image_url' => "default.png",
        ]);


        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user', 'token'),201);
    }

    public function registerWithFile(Request $request){
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'university_id' => 'required',
            'phone' => 'required',
            'user_file' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
            'username' => $request->get('username'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'university_id' => $request->get('university_id'),
            'phone' => $request->get('phone'),
            'image_url' => "default.png",
        ]);



        $token = JWTAuth::fromUser($user);
        
        // User File
        $userFileRequest = $request->file('user_file');
        $userFileData = [];
        
        foreach ($userFileRequest as $fileCategoryId => $file) {
            
            $fileName = Str::orderedUuid().'.'.$file->getClientOriginalExtension();;
            $file->move('upload/userfile/', $fileName);
            $userFileData[] = [                
                'user_id' => $user["id"],
                'file_category_id' => $fileCategoryId, 
                'file_url' => 'upload/userfile/'.$fileName,
                "created_at" =>  \Carbon\Carbon::now(), 
                "updated_at" => \Carbon\Carbon::now(),  
            ];
        }


        
        $userfile = UserFile::insert($userFileData);

        // return response()->json(compact('userfile'),201);

        return response()->json(compact('user', 'token', 'userfile'),201);
    }

    public function getAuthenticatedUser()
    {
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (TokenExpiredException $e) {
            
            return response()->json(['token_expired'], 403);

        } catch (TokenInvalidException $e) {
            
            return response()->json(['token_invalid'], 403);

        } catch (JWTException $e) {

            return response()->json(['token_absent'], 403);

        }

        return response()->json(compact('user'));
    }

    public function logout(){
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json(["logout" => "true"]);
    }
}
