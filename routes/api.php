<?php

use App\Http\Controllers\Api\BidController;
use App\Http\Controllers\Api\GroupController;
use App\Http\Controllers\Api\JobController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/auth/register', [RegisterController::class, 'register']);
Route::post('/auth/token', [LoginController::class, 'token']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/me', static function (Request $request): JsonResponse {
        return response()->json(new UserResource($request->user()));
    });

    Route::post('groups/join/{group}', [GroupController::class, 'join']);

    Route::get('groups/myGroups', [GroupController::class, 'myGroups']);

    Route::resource('groups', GroupController::class);

    Route::resource('jobs', JobController::class)->withoutMiddleware("throttle:api");

    Route::resource('bids', BidController::class);

    Route::resource('reports', ReportController::class);

    Route::post('/validate', static function () {
        return response()->json(['message' => 'valid']);
    });
});

