<?php

namespace App\Jobs;

class SubscriptionPaymentSuccessJob extends BaseSubscriptionJob
{

    public function handle(): void
    {
        $this->getSubscription()->successfulPayment($this->gatewaySubscription['next_billing_date']);
    }
}
