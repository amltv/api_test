<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class GroupsController extends Controller
{
    public function getGroups()
    {
        $groups = Group::all();

        return response()->json([
            'status' => true,
            'groups' => $groups->toArray()
        ]);
    }

    public function postGroups(Request $request)
    {
        try {
            $group = new Group($request->post());
            $group->saveOrFail();

            return response()->json(['status' => true]);
        } catch (\Exception $exception) {
            return response()->json(['status' => false]);
        }
    }

    public function putGroupsById(Request $request, $group_id)
    {
        try {
            /** @var Group $group */
            $group = Group::findOrFail($group_id);
            $group->fill($request->post());
            $group->saveOrFail();

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
