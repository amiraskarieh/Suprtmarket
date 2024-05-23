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

    public function addRelation(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'type' => 'required|in:customer,employee',
            'related_id' => 'required|integer'
        ]);

        $user = User::findOrFail($request->user_id);

        if (!is_null($user->userable_type)) {
            return response()->json(['error' => 'User already has a polymorphic relation'], 400);
        }

        if ($request->type == 'customer') {
            $user->userable()->associate(\App\Models\Customer::findOrFail($request->related_id));
        } elseif ($request->type == 'employee') {
            $user->userable()->associate(\App\Models\Employee::findOrFail($request->related_id));
        }

        $user->save();

        return response()->json(['message' => 'Relation added successfully']);
    }
}
