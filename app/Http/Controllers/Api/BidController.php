<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BidFormRequest;
use App\Http\Resources\BidResource;
use App\Models\Bid;
use App\Models\Job;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class BidController extends Controller
{
    public function index(): JsonResponse
    {
        $bids = BidResource::collection(Bid::orderBy('id', 'asc')->get());

        return response()->json($bids);
    }

    public function jobBids($id): JsonResponse
    {
        $bids = BidResource::collection(Job::findOrFail($id)->bids()->orderBy('id', 'asc')->get());

        return response()->json($bids);

    }

    public function win(Request $request): JsonResponse
    {
        $bid = Bid::findOrFail($request->get('bid'));

        $job = $bid->job;

        $jobsBids = $job->bids;

        foreach ($jobsBids as $lostBid) {
            $lostBid->update(['status' => 'Lost']);
            $lostBid->save();
        }

        $job->update([
            'winner_id' => $bid->user_id,
            'status'    => 'In Progress'
        ]);

        $bid->update([
            'status' => 'Won'
        ]);

        return response()->json(['status' => 'good']);
    }

    public function update(BidFormRequest $request, Bid $bid): JsonResponse
    {
        $bid->update([
            'date'      => $request->get('date'),
            'money'     => $request->get('money'),
            'few_words' => $request->get('few_words'),
            'status'    => $request->get('status'),
        ]);

        return response()->json($bid);
    }

    public function myBids(Request $request): JsonResponse
    {
        $bids = BidResource::collection(Bid::all()->where('user_id', '=', $request->user()->id));

        return response()->json($bids);
    }

    public function store(BidFormRequest $request): JsonResponse
    {
        $job = Job::findOrFail($request->get('job_id'));

        if ($job->bids->contains('user_id', '=', $request->user()->id)) {
            return response()->json(['status' => 'You already have a bid!']);
        }

        $bid = Bid::create([
            'job_id'    => $request->get('job_id'),
            'date'      => $request->get('date'),
            'money'     => $request->get('money'),
            'few_words' => $request->get('few_words'),
            'user_id'   => $request->user()->id,
            'status'    => 'In Progress',
        ]);

        return response()->json(new BidResource($bid));
    }

    public function show(Bid $bid): JsonResponse
    {
        return response()->json(new BidResource($bid));
    }

    public function destroy(Bid $bid): JsonResponse
    {
        $bid->delete();

        return response()->json(['delete' => 'successful']);
    }
}
