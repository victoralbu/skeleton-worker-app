<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobFormRequest;
use App\Http\Resources\JobResource;
use App\Models\Job;
use App\Models\Photo;
use Illuminate\Http\JsonResponse;

class JobController extends Controller
{
    public function index(): JsonResponse
    {
        $jobs = JobResource::collection(Job::orderBy('id', 'asc')->get());

        return response()->json($jobs);
    }

    public function store(JobFormRequest $request): JsonResponse
    {
        $job = Job::create([
            'title'       => $request->get('title'),
            'description' => $request->get('description'),
            'level'       => $request->get('level'),
            'budget'      => $request->get('budget'),
            'address'     => $request->get('address'),
            'urgency'     => $request->get('urgency'),
            'user_id'     => $request->user()->id,
            'group_id'    => $request->get('group_id'),
            'winner_id'   => $request->get('winner_id'),
            'status'      => 'Bidding',
        ]);

        foreach ($request->get('image') as $image) {
            Photo::create([
                'image'  => $image,
                'job_id' => $job->id,
            ]);
        }

        return response()->json(new JobResource($job));
    }

    public function show(Job $job): JsonResponse
    {
        return response()->json(new JobResource($job));
    }

    public function update(JobFormRequest $request, Job $job): JsonResponse
    {
        $job->update([
            'title'       => $request->get('name'),
            'description' => $request->get('description'),
            'level'       => $request->get('level'),
            'budget'      => $request->get('budget'),
            'address'     => $request->get('address'),
            'status'      => $request->get('status'),
        ]);

        return response()->json($job);
    }

    public function destroy(Job $job): JsonResponse
    {
        $job->delete();

        return response()->json(['delete' => 'successful']);
    }
}
