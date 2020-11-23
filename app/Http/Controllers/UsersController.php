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
        if (Auth::guard('users')->check()){
            auth()->guard('users')->logout();
            return response()->json(['message' => 'Successfully loged out']);
        }
        return response()->json(['message' => 'Failed loged out']);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $users = Users::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'image'=>'N/A',
            'role'=>'user',
        ]);

        $token = JWTAuth::fromUser($users);

        return response()->json(compact('users','token'),201);
    }

    public function getAuthenticatedUser()
    {
        try {

            if (! $users = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }

        return response()->json(compact('users'));
    }

    public function update(Request $request) {

        $users = JWTAuth::parseToken()->authenticate();
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|',
            'password' => 'required|string|min:6',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        if($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/users/', $filename);
        }else{
            $filename= 'N/A';
        }

        if($request->get('password')==NULL){
            $password = $users->password;
        } else{
            $password = $request->get('password');
        }

        $users->update([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($password),
            'image'=>$filename
        ]);

        return response()->json(compact('users'));
        
    }
}