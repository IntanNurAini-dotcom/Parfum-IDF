<?php

use App\Http\Controllers\Api\MidtransWebhookController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Midtrans notification webhook integration structure (PRD Section 11)
*/

Route::post('/midtrans/notification', [MidtransWebhookController::class, 'handle'])->name('midtrans.notification');
