<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'name' => 'required|max:225',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role_id' => 'required|integer|exists:roles,id|not_in:1'
        ]);

        $result = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => $request['password'],
            'role_id' => $request['role_id'],
        ]);

        return response([
            'message' => 'success create new user',
            'data' => new UserResource($result),
        ]);
    }
}