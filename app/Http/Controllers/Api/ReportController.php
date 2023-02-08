<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReportFormRequest;
use App\Http\Resources\ReportResource;
use App\Models\Report;
use Illuminate\Http\JsonResponse;

class ReportController extends Controller
{
    public function index(): JsonResponse
    {
        $reports = ReportResource::collection(Report::orderBy('id', 'asc')->get());

        return response()->json($reports);
    }

    public function store(ReportFormRequest $request): JsonResponse
    {
        $report = Report::create([
            'description'  => $request->get('description'),
            'plaintiff_id' => $request->user()->id,
            'culprit_id'   => $request->get('culprit_id'),
        ]);

        return response()->json(new ReportResource($report));
    }

    public function show(Report $report): JsonResponse
    {
        return response()->json(new ReportResource($report));
    }

//    public function update(ReportFormRequest $request, Report $report): JsonResponse
//    {
//        $report->update([
//
//        ]);
//
//        return response()->json($report);
//    }

    public function destroy(Report $report): JsonResponse
    {
        $report->delete();

        return response()->json(['delete' => 'successful']);
    }
}
