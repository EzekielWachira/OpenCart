<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
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
            'VIEW_PRODUCTS', 'VIEW_CATEGORIES', 'VIEW_CART',
            'ADD_CART', 'DELETE_CART', 'VIEW_WISHLIST', 'ADD_WISHLIST',
            'REMOVE_WISHLIST'
        ])->plainTextToken;
    }

    public function logout(Request $request) {
        $request->user()->tokens()->delete();
        return response([
            'message' => 'You logged out'
        ]);
    }
}
