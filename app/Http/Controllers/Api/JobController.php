<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobFormRequest;
use App\Http\Resources\JobResource;
use App\Models\Job;
use App\Models\Photo;
use Doctrine\DBAL\Schema\Schema;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $lastJob = $request->get('lastPost') ?: PHP_INT_MAX;

        $jobs = JobResource::collection(Job::orderBy('id', 'desc')->take(10)->where('id', '<', $lastJob)->get());

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
            'city'        => $request->get('city'),
            'urgency'     => $request->get('urgency'),
            'user_id'     => $request->user()->id,
            'group_id'    => $request->get('group_id'),
            'winner_id'   => $request->get('winner_id'),
            'status'      => 'Bidding',
        ]);

        if ($request->allFiles() !== null) {

            $images = $request->allFiles();

            foreach ($images as $image) {

                $name = $image->getFilename() . $request->user()->id . '.' . $image->extension();

                Photo::create([
                    'image'  => '/assets/images/' . $name,
                    'job_id' => $job->id,
                ]);

                $image->storeAs('', $name, ['disk' => 'frontend']);
            }
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
            'city'        => $request->get('city'),
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
