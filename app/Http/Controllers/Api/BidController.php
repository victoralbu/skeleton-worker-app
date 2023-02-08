<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BidFormRequest;
use App\Http\Resources\BidResource;
use App\Models\Bid;
use Illuminate\Http\JsonResponse;

class BidController extends Controller
{
    public function index(): JsonResponse
    {
        $bids = BidResource::collection(Bid::orderBy('id', 'asc')->get());

        return response()->json($bids);
    }

    public function store(BidFormRequest $request): JsonResponse
    {
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

    public function destroy(Bid $bid): JsonResponse
    {
        $bid->delete();

        return response()->json(['delete' => 'successful']);
    }
}
