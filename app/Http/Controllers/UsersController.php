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
        return response()->json([$auth]);
    }
    
    public function me() {
        $credentials = JWTAuth::parseToken()->authenticate();
        return response()->json([$credentials]);
    }

    public function logout() {
        if (Auth::guard('users')->check()){
            auth()->guard('users')->logout();
        }
        return response()->json(['message' => 'Successfully loged out']);
    }

    // public function refresh() {
    //     if (Auth::guard('users')->check()){
    //         $auth = $this->respondWithToken(auth('users')->refresh());
    //     }
    //     return response()->json([$auth]);
    // }

    // protected function respondWithToken($token, $users) {
    //     return response()->json([
    //         'access_token' => $token,
    //         'token_type' => 'bearer',
    //         'expires_in' => auth($users)->factory()->getTTL() * 60,
    //         'account' => auth($users)->user()
    //     ]);
    // }

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
            'password' => 'required|string|min:6|confirmed',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $users = Users::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
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

    public function editProfile(Users $users) {
        return response()->json($users);
    }

    public function update(Request $request, Users $users) {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'image' => 'required|image|mimes:png,jpeg,jpg'
        ]);

        if($request->hasFile('image')) {
            Storage::delete('/public/users/' . $users->image);
        }

        $file = $request->file('image');
        $filename =  time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('/public/users/', $filename);
        
        $users = Users::update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'image' => $filename
        ]);
        return response()->json($users);
    }

    public function storeLocation(Request $request, Users $users) {
        $users = Users::update([
            'longitude' => $request->longitude,
            'latitude' => $request->latitude
        ]);
        return response()->json(compact('users'));
    }

}