<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserFormRequest;
use App\Models\Bid;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(Request $request): JsonResponse
    {
        $user = $request->user();

        $users = [];

        $workers = Job::select(['winner_id', 'status', 'id'])
                      ->where('user_id', '=', $user->id)
                      ->where('winner_id', '!=', null)
                      ->get();

        foreach ($workers as $worker) {
            $subject = User::where('id', $worker->winner_id)->first();

            if ($worker->status === 'Done') {
                $subject->amount = Bid::where('job_id', '=', $worker->id)->first()->money;
                $subject->job_id = $worker->id;
            } else {
                $subject->amount = '';
            }


            $subject->status = $worker->status;

            $users[] = $subject;
        }

//        $users = UserResource::collection($users);

        return response()->json($users);
    }

    public function update(UserFormRequest $request): JsonResponse
    {
        $user = $request->user();



        $user->update([
            'name'         => $request->get('name'),
            'email'        => $request->get('email'),
            'phone_number' => $request->get('phone_number'),
        ]);

        return response()->json(['status' => 'good']);
    }
}