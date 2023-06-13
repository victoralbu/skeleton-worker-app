<?php

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PayPalPaymentController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::controller(PayPalPaymentController::class)
     ->prefix('paypal')
     ->group(function () {
         Route::view('payment', 'paypal.index')->name('create.payment');
         Route::post('handle-payment', 'handlePayment')->name('make.payment');
         Route::get('cancel-payment', 'paymentCancel')->name('cancel.payment');
         Route::get('payment-success', 'paymentSuccess')->name('success.payment');
     });

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');


Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request): RedirectResponse {
    $request->fulfill();

    return Redirect::to('http://zeusv.go.ro:3001/');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::get('/auth/login', function () {
    return Redirect::to('http://zeusv.go.ro:3001/');
})->name('login');
