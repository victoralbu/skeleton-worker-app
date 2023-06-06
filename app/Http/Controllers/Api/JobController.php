<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobFormRequest;
use App\Http\Resources\JobResource;
use App\Models\Group;
use App\Models\Job;
use App\Models\Photo;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class JobController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $lastJob = $request->get('lastPost') ?: PHP_INT_MAX;

        $city = $request->get('city') ?: 'Brasov';

        $jobs = JobResource::collection(Job::orderBy('id', 'desc')
                                           ->take(10)
                                           ->where('id', '<', $lastJob)
                                           ->where('city', '=', $city)
                                           ->where('group_id', '=', null)
                                           ->where('winner_id', '=', null)
                                           ->get());

        return response()->json($jobs);
    }

    public function myPosts(Request $request): JsonResponse
    {
        $lastJob = $request->get('lastPost') ?: PHP_INT_MAX;

        $jobs = JobResource::collection(Job::orderBy('id', 'desc')
                                           ->take(10)
                                           ->where('id', '<', $lastJob)
                                           ->where('user_id', "=", $request->user()->id)
                                           ->get());

        return response()->json($jobs);
    }

    public function groupPosts(Request $request): JsonResponse
    {
        if (!Auth::user()->groups->contains($request->get('group')))
            return response()->json(['status' => 'Forbidden']);

        $lastJob = $request->get('lastPost') ?: PHP_INT_MAX;

        $jobs = JobResource::collection(Job::orderBy('id', 'desc')
                                           ->take(10)
                                           ->where('id', '<', $lastJob)
                                           ->where('group_id', "=", $request->get('group'))
                                           ->where('winner_id', '=', null)
                                           ->get());

        return response()->json($jobs);
    }

    public function myJobs(Request $request): JsonResponse
    {
        $jobs = Job::where('winner_id','=', $request->user()->id)->get();

       return response()->json($jobs);
    }

    public function finishJob(Request $request):JsonResponse
    {
        $job = Job::where('id','=',$request->get('job_id'));

        $job->update(['status' => 'Done']);

        return response()->json(['status' => 'good']);
    }

    public function paid(Request $request)
    {
        $job = Job::where('id','=', $request->get('job_id'));
        $job->update(['status' => 'Paid']);

        return response()->json(['status' => 'good']);
    }

    public function store(JobFormRequest $request): JsonResponse
    {
        $payload = [
            'title'       => $request->get('title'),
            'description' => $request->get('description'),
            'level'       => $request->get('level'),
            'budget'      => $request->get('budget'),
            'address'     => $request->get('address'),
            'city'        => $request->get('city'),
            'urgency'     => $request->get('urgency'),
            'user_id'     => $request->user()->id,
            'winner_id'   => $request->get('winner_id'),
            'status'      => 'Bidding'
        ];

        if ($request->get('group_id') !== "null")
            if (Group::findOrFail($request->get('group_id')))
                $payload['group_id'] = $request->get('group_id');

        $job = Job::create($payload);

        if ($request->allFiles() !== null) {

            $images = $request->allFiles();

            foreach ($images as $image) {

                $name = $image->getFilename() . $request->user()->id . '.' . $image->extension();

                $image = Image::make($image->getRealpath());

                $image->orientate();

                Photo::create([
                    'image'  => '/assets/images/' . $name,
                    'job_id' => $job->id,
                ]);

                $image->save('../../../testFrontendLicenta/public/assets/images/' . $name, 100);

            }
        }

        return response()->json(new JobResource($job));
    }

    public function show($id)
    {
        $job = Job::where('id', $id)->firstOrFail();
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
