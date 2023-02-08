<?php

use App\Http\Controllers\Api\BidController;
use App\Http\Controllers\Api\GroupController;
use App\Http\Controllers\Api\JobController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Resources\JobResource;
use App\Http\Resources\UserResource;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/auth/register', [RegisterController::class, 'register']);
Route::post('/auth/token', [LoginController::class, 'token']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', function (Request $request): UserResource {
        return new UserResource($request->user());
    });

    Route::resource('groups', GroupController::class);

    Route::resource('jobs', JobController::class);

    Route::resource('bids', BidController::class);

    Route::resource('reports', ReportController::class);
});

Route::get('/test', function () {
    return new JobResource(Job::find(1));
});

