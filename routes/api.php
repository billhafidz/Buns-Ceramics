<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

Route::post('/payment/notification', [PaymentController::class, 'handleNotification'])->name('payment.notification');

