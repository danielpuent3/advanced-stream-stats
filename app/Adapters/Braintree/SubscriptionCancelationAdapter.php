<?php

namespace App\Adapters\Braintree;

use App\Models\Subscription;
use Braintree\Gateway;

class SubscriptionCancelationAdapter
{

    /**
     * @throws \Exception
     */
    public function cancel(Gateway $gateway, Subscription $subscription)
    {
        //set number of billing cycles to 1 so sub will expire at the end of it's term
        $result = $gateway->subscription()->update($subscription->external_subscription_id, [
            'numberOfBillingCycles' => 1
        ]);

        if ( ! $result->success)
        {
            throw new \Exception('Unable to update gateway subscription.');
        }

        return $result->subscription;
    }
}
