<?php

use App\Http\Controllers\Webhooks\BraintreeWebhooksController;
use Illuminate\Support\Facades\Route;

Route::post('braintree/subscriptions', [BraintreeWebhooksController::class, 'subscriptions'])->name('webhooks.braintree.subscriptions');
