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

            $subject->job_id = $worker->id;

            if ($worker->status === 'Done') {
                $subject->amount = Bid::where('job_id', '=', $worker->id)->where('user_id', '=', $subject->id)->first()->money;
            } else {
                $subject->amount = '';
            }

            $subject->status = $worker->status;

            $ratings = json_decode($subject->ratings, true);

            if (isset($ratings[$request->user()->id . "|" . $subject->job_id]))
                $subject->canBeRated = false;
            else
                $subject->canBeRated = true;

            $users[] = $subject;
        }

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
