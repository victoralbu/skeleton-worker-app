<?php

use App\Http\Controllers\Api\BidController;
use App\Http\Controllers\Api\ForgotPassword;
use App\Http\Controllers\Api\GroupController;
use App\Http\Controllers\Api\JobController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\RateController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\PayPalPaymentController;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/auth/register', [RegisterController::class, 'register']);

Route::post('/auth/token', [LoginController::class, 'token']);

Route::post('/auth/forgot-password', [ForgotPassword::class, 'index'])->name('password.reset');

Route::post('/auth/reset-password', [ForgotPassword::class, 'reset']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/me', static function (Request $request): JsonResponse {
        return response()->json(new UserResource($request->user()));
    });

    Route::post('/auth/logout', static function () {
        Auth::guard('web')->logout();
    });

    Route::post('groups/join', [GroupController::class, 'join']);

    Route::get('groups/myGroups', [GroupController::class, 'myGroups']);

    Route::resource('groups', GroupController::class);

    Route::resource('jobs', JobController::class)->withoutMiddleware("throttle:api");

    Route::get('myPosts', [JobController::class, 'myPosts'])->withoutMiddleware("throttle:api");

    Route::get('my-jobs', [JobController::class, 'myJobs'])->withoutMiddleware("throttle:api");

    Route::get('groupPosts', [JobController::class, 'groupPosts'])->withoutMiddleware("throttle:api");

    Route::get('bids/{id}', [BidController::class, 'jobBids'])->withoutMiddleware("throttle:api");

    Route::post('bids/my-bids', [BidController::class, 'myBids'])->withoutMiddleware("throttle:api");

    Route::post('bids/win', [BidController::class, 'win']);

    Route::post('jobs/finish', [JobController::class, 'finishJob']);

    Route::post('jobs/paid', [JobController::class, 'paid']);

    Route::post('rate', [RateController::class, 'rate']);

    Route::get('my-workers', [UserController::class, 'show']);

    Route::post('profile', [UserController::class, 'update']);

    Route::resource('bids', BidController::class);

    Route::resource('reports', ReportController::class);

    Route::post('handle-payment', [PayPalPaymentController::class, 'handlePayment'])->name('make.payment');

    Route::post('/validate', static function () {
        return response()->json(['message' => 'valid']);
    });
});

