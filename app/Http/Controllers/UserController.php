<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request) {
        $user = User::where('username', $request->username)->first();

        if(!$user || $request->password != $user->password) {
            return response()->json([
                'message' => 'Incorrect username or password'
            ], 401);
        }

        $token = uuid_create();

        $user->update([
            'token' => $token
        ]);

        Auth::login($user);

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
}
