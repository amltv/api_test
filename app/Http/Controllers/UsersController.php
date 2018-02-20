<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function getUsers()
    {
        $users = User::all();

        return response()->json($users->toArray());
    }

    public function postUsers(Request $request)
    {

    }

    public function getUsersById(Request $request)
    {

    }

    public function putUsersById(Request $request)
    {

    }
}
