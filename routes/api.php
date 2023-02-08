<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Resources\GroupResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/auth/register', [RegisterController::class, 'register']);
Route::post('/auth/token', [LoginController::class, 'token']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', function (Request $request): UserResource {
        return new UserResource($request->user());
    });
});

Route::get('/test', function (){
    return new \App\Http\Resources\JobResource(\App\Models\Job::find(1));
});
