<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function login(Request $request) {
        if(!Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            return response()->json([
                'message' => 'Incorrect username or password'
            ], 401);
        }

        $user = User::find(Auth::user()->id);
        
        $token = uuid_create();

        $user->update([
            'token' => $token
        ]);

        return response()->json([
            'message' => 'Login success',
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'accessToken' => $user->token
            ]
        ]);

    }   

    public function logout(Request $request) {
        $user = User::where('token', $request->bearerToken())->first();

        if(!$user) {
            return response()->json([
                'message' => 'Invalid token'
            ], 401);
        }

        $user->update([
            'token' => null
        ]);

        return response()->json([
            'message' => 'Logout success'
        ]);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'unique:users'], 
            'password' => ['required'],
            'role' => ['required'],
        ]);

        if($validator->fails()) {
            return response()->json([
                'message' => 'Invalid field',
                'errors' => $validator->errors()
            ]);
        }

        $user = User::create([
            'username' => $request->username,
            'password' => $request->password,
            'role' => $request->role,
        ]);


        return response()->json([
            'message' => 'New user created',
            'user' => [
                'username' => $user->username,
                'password' => $user->password,
                'role' => $user->role,
            ]
        ]);
    }

    public function update(Request $request) {
        $user = User::find(Auth::user());

        $user->update([
            'username' => $request->username,
            'password' => $request->password,
        ]);

        return response()->json([
            'message' => 'User updated'
        ]);
    }
}
