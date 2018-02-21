<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function getUsers()
    {
        $users = User::all();

        return response()->json([
            'status' => true,
            'users' => $users->toArray()
        ]);
    }

    public function postUsers(Request $request)
    {
        try {
            $user = new User($request->post());
            $user->saveOrFail();

            return response()->json(['status' => true]);
        } catch (\Exception $exception) {
            return response()->json(['status' => false]);
        }
    }

    public function getUsersById(Request $request, $user_id)
    {
        try {
            $user = User::findOrFail($user_id);

            return response()->json([
                'user' => $user->toArray(),
                'status' => true
            ]);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'status' => false
            ]);
        }
    }

    public function putUsersById(Request $request, $user_id)
    {
        try {
            /** @var User $user */
            $user = User::findOrFail($user_id);
            $user->fill($request->post());
            $user->saveOrFail();

            return response()->json([
                'status' => true
            ]);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'status' => false
            ]);
        } catch (QueryException $exception) {
            return response()->json([
                'status' => false
            ]);
        }
    }
}
