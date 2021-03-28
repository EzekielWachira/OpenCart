<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUsers() {
//        $users = User::all();
        return UserResource::collection(User::all());
    }
}
