<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebhookController;

Route::post('/webhook/order-status', [WebhookController::class, 'handle']);
