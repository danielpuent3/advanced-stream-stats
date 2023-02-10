<?php

namespace App\Adapters\Braintree;

use Braintree\Gateway;
use Exception;

class PaymentMethodCreationAdapter
{

    /**
     * @throws Exception
     */
    public function create(Gateway $gateway, string $nonce)
    {
        $customerResult = $gateway->customer()->create();
        if ( ! $customerResult->success)
        {
            throw new Exception('Unable to create gateway customer.');
        }

        $result = $gateway->paymentMethod()->create([
            'customerId' => $customerResult->customer->id,
            'paymentMethodNonce' => $nonce,
        ]);

        if ( ! $result->success)
        {
            throw new Exception('Unable to create gateway payment method.');
        }

        return $result->paymentMethod;
    }
}
