<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
Use Crypt;

class UsersController extends Controller
{
    public function test() {
        if (Auth::guard('users')->check()){
            $auth = Auth::guard('users')->user();
        }
        return response()->json($auth);
    }
    
    public function me() {
        $credentials = JWTAuth::parseToken()->authenticate();
        return response()->json(compact('credentials'));
    }

    public function logout() {

        try {

            if (! $users = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['status'=>'user_not_found'], 404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['status'=>'token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['status'=>'token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['status'=>'token_absent'], $e->getStatusCode());

        }

        if (Auth::guard('users')->check()){
            auth()->guard('users')->logout();
            return response()->json(['status' => 'Successfully logged out']);
        }
        return response()->json(['status' => 'Failed logged out']);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['status' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['status' => 'could_not_create_token'], 500);
        }

        $status = "Login is Success";
        return response()->json(compact('token', 'status'));
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if($validator->fails()){
            return response()->json(['status' => $validator->errors()->toJson()], 400);
        }

        $users = Users::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'image'=>'N/A',
            'role'=>'user',
        ]);

        $token = JWTAuth::fromUser($users);
        $status = "register is success";

        return response()->json(compact('users','token', 'status'),201);
    }

    public function getAuthenticatedUser()
    {
        try {

            if (! $users = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['status'=>'user_not_found'], 404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['status'=>'token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['status'=>'token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['status'=>'token_absent'], $e->getStatusCode());

        }

        $status = "Token is Valid";

        return response()->json(compact(['users', 'status']));
    }

    public function update(Request $request) {

        try {

            if (! $users = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['status'=>'user_not_found'], 404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['status'=>'token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['status'=>'token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['status'=>'token_absent'], $e->getStatusCode());

        }

        $users = JWTAuth::parseToken()->authenticate();
        

        if($request->hasFile('image')) {
            $validator = Validator::make($request->all(), [
                'image'=>'required|image|mimes:png,jpeg,jpg',
                //'password' => 'required|string|min:6'

            ]);
            
            if($validator->fails()){
                return response()->json(['status' => $validator->errors()->toJson()], 400);
            }

            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            
            Storage::delete('/public/users/' . $users->image);
            $file->storeAs('public/users/', $filename);

        }else{
            $filename= 'N/A';
        }

        if($request->get('name')==NULL){
            $name = $users->name;
        } else{
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255'
            ]);
            
            if($validator->fails()){
                return response()->json(['status' => $validator->errors()->toJson()], 400);
            }
            $name = $request->get('name');
        }

        if($request->get('email')==NULL){
            $email = $users->email;
        } else{
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email|max:255|unique:users'
            ]);
            
            if($validator->fails()){
                return response()->json(['status' => $validator->errors()->toJson()], 400);
            }
            $email = $request->get('email');
        }

        if($request->get('password')==NULL){
            $password = $users->password;
            $users->update([
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'image'=>$filename
            ]);
    
            $status = "Token is Valid";
    
            return response()->json(compact(['users', 'status']));
        } else{
            $validator = Validator::make($request->all(), [
                'password' => 'required|string|min:6'
            ]);
            
            if($validator->fails()){
                return response()->json(['status' => $validator->errors()->toJson()], 400);
            }
            
            $password = $request->get('password');
        }

        $users->update([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'image'=>$filename
        ]);

        $status = "Token is Valid";

        return response()->json(compact(['users', 'status']));
        
    }
}