<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GroupFormRequest;
use App\Http\Resources\GroupResource;
use App\Models\Group;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GroupController extends Controller
{
    public function index(): JsonResponse
    {
        $groups = GroupResource::collection(\Auth::user()->groups);

        return response()->json($groups);
    }

    public function store(GroupFormRequest $request): JsonResponse
    {
        $group = Group::create([
            'name'        => $request->get('name'),
            'description' => $request->get('description'),
            'admin_id'    => $request->user()->id,
            'invite_code' => $request->user()->id . Str::random(5) . random_int(1, 1000),
            'members_nr'  => 1,
        ]);

        $group->users()->attach($request->user());

        return response()->json(new GroupResource($group));
    }

    public function show(Group $group): JsonResponse
    {
        return response()->json(new GroupResource($group));
    }

    public function destroy(Group $group): JsonResponse
    {
        $group->delete();

        return response()->json(['delete' => 'successful']);
    }

    public function join(Request $request): JsonResponse
    {
        $group = Group::where('invite_code', '=', $request->get('invite_code'))->first();

        if ($request->user()->id === $group->admin_id)
            return response()->json(['error' => 'You are the owner!']);

//        if ($request->get('invite_code') !== $group->invite_code)
//            return response()->json(['error' => 'Incorrect invite code!']);

        $group->update([
            'members_nr' => $group->members_nr + 1,
        ]);

        $group->users()->attach($request->user());

        return response()->json(['status' => 'successful']);
    }

    public function update(GroupFormRequest $request, Group $group): JsonResponse
    {
        $group->update([
            'name'        => $request->get('name'),
            'description' => $request->get('description'),
        ]);

        return response()->json($group);
    }

    public function myGroups(Group $group, Request $request): JsonResponse
    {
        $user = $request->user();

        $groups = GroupResource::collection($user->groups);

        return response()->json($groups);
    }
}
