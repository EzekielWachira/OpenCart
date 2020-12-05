<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        if ($user) {
            return response([
                'message' => 'User created'
            ]);
        } else {
            return response([
                'error' => 'an error occurred while registering you to database'
            ]);
        }
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'error' => 'User email or password do not match with our records'
            ]);
        }
        return $user->createToken('AUTH_TOKEN', [
            'ADD_PRODUCT', 'DELETE_PRODUCT', 'UPDATE_PRODUCT', 'ADD_CATEGORY',
            'DELETE_CATEGORY', 'UPDATE_CATEGORY', 'REMOVE_USER', 'ADD_USER'
        ])->plainTextToken;
    }

    public function logout(Request $request) {
        $request->user()->tokens()->delete();
        return response([
            'message' => 'You logged out'
        ]);
    }
}
