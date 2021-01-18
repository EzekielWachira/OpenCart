<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Controllers\Controller;
use App\Http\Resources\AdminResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function register(Request $request){
        $singleAdmin = User::where('email', $request->email)->first();
        $admin = new Admin();
        $admin->admin_id = $singleAdmin->id;
        if ($admin) {
            $admin->save();
            return response([
                'message' => 'Admin added'
            ]);
        } else {
            return response([
                'message' => 'Error adding admin to database'
            ]);
        }

//
//        $request->validate([
//            'name' => 'required|string|max:255',
//            'email' => 'required|email|unique:users',
//            'password' => 'required|confirmed'
//        ]);

//        $user = User::create([
//            'name' => $request->name,
//            'email' => $request->email,
//            'password' => Hash::make($request->password),
//            'isAdmin' => true
//        ]);
//        $user = new User();
//        $user->name = $request->name;
//        $user->email = $request->email;
//        $user->password = Hash::make($request->password);
//        $user->isAdmin = true;
//
//        if ($user) {
//            $user->save();
//            return response([
//                'message' => 'User created'
//            ]);
//        } else {
//            return response([
//                'error' => 'an error occurred while registering you to database'
//            ]);
//        }
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

    public function listAllAdmins() {
        $admins = Admin::all();
//        foreach ($admins as $admin){
////            $users = User::findOrFail($admin->id);
//             return new AdminResource($users);
//        }
        return new AdminResource($admins);
    }
}
