<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GroupFormRequest;
use App\Http\Resources\GroupResource;
use App\Models\Group;
use Illuminate\Http\JsonResponse;

class GroupController extends Controller
{
    public function index(): JsonResponse
    {
        $groups = GroupResource::collection(Group::orderBy('id', 'asc')->get());

        return response()->json($groups);
    }

    public function store(GroupFormRequest $request): JsonResponse
    {
        $group = Group::create([
            'name'        => $request->get('name'),
            'description' => $request->get('description'),
            'admin_id'    => $request->user()->id,
            'invite_code' => $request->user()->id . fake()->unique()->text(5) . random_int(1, 1000),
            'members_nr'  => 1,
        ]);

        return response()->json(new GroupResource($group));
    }

    public function show(Group $group): JsonResponse
    {
        return response()->json(new GroupResource($group));
    }

    public function update(GroupFormRequest $request, Group $group): JsonResponse
    {
        $group->update([
            'name'        => $request->get('name'),
            'description' => $request->get('description'),
        ]);

        return response()->json($group);
    }

    public function destroy(Group $group): JsonResponse
    {
        $group->delete();

        return response()->json(['delete' => 'successful']);
    }
}
