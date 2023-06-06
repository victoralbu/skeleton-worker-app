<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PayPalPaymentController;

Route::controller(PayPalPaymentController::class)
     ->prefix('paypal')
     ->group(function () {
         Route::view('payment', 'paypal.index')->name('create.payment');
         Route::post('handle-payment', 'handlePayment')->name('make.payment');
         Route::get('cancel-payment', 'paymentCancel')->name('cancel.payment');
         Route::get('payment-success', 'paymentSuccess')->name('success.payment');
     });
