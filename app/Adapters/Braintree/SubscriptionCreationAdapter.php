<?php

namespace App\Adapters\Braintree;

use Braintree\Gateway;

class SubscriptionCreationAdapter
{

    /**
     * @throws \Exception
     */
    public function create(Gateway $gateway, string $paymentMethodToken, string $planId)
    {
        $result = $gateway->subscription()->create([
            'paymentMethodToken' => $paymentMethodToken,
            'planId' => $planId,
        ]);

        if ( ! $result->success)
        {
            throw new \Exception('Unable to create gateway subscription.');
        }

        return $result->subscription;
    }
}
