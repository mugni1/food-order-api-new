<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // profile function
    public function profile(Request $request){
        return new UserResource($request->user());
    }

    // login
    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();
        if(!$user){
            return response(['message' => 'Wrong email, please check again'], 403);
        }
        if(!Hash::check($request['password'], $user['password'])){
            return response(['message' => 'Incorrect password'], 403);
        }

        // generate token
        $token = $user->createToken('auth_token')->plainTextToken;

        // masukan token ke $user
        // $user['token'] = $token;

        // return
        return response([
            'message' => 'Login Success',
            'token' => $token,
            'data' => new UserResource($user)
        ]);

    }

    // login and logout from all device
    public function loginLogoutAll(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request['email'])->first();
        if(!$user){
            return response(['message' => 'Wrong email, please check again'], 403);
        }
        if(!Hash::check($request['password'], $user['password'])){
            return response(['message' => 'Incorrect password'], 403);
        }

        // logout dari semua perangkat
        $user->tokens()->delete();

        // create new token
        $token = $user->createToken('auth_token')->plainTextToken;

        //return
        return response([
            'message' => 'success login and logout from all device',
            'token' => $token,
            'data' => new UserResource($user)
        ]);
    }

    // logout
    public function logout(Request $request){
        $user = $request->user();

        $user->currentAccessToken()->delete();

        return response([
            'message' => "success logout",
            'data' => new UserResource($user)
        ]);
    }

    // logout from all device
    public function logoutAll(Request $request){
        $user = $request->user();

        $user->tokens()->delete();

        return response([
            'message' => 'success logout from all device',
            'data' => new UserResource($user)
        ]);
    }
}