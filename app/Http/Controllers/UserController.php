<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUsersWithoutPolymorphism()
    {
        $users = User::whereNull('userable_type')->get();
        return response()->json($users);
    }
}
