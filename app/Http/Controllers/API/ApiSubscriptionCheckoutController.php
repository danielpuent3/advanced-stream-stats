<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateSubscriptionRequest;
use App\Http\Resources\SubscriptionResource;
use App\Services\SubscriptionService;
use Exception;

class ApiSubscriptionCheckoutController extends Controller
{

    public function __construct(private SubscriptionService $subscriptionService)
    {
    }

    /**
     * @throws Exception
     */
    public function store(CreateSubscriptionRequest $request)
    {
        $subscription = $this->subscriptionService->create(
            $request->user(),
            $request->get('nonce'),
            $request->get('plan')
        );

        return SubscriptionResource::make($subscription);
    }
}
