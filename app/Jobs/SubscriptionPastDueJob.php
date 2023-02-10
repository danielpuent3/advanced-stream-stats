<?php

namespace App\Jobs;

class SubscriptionPastDueJob extends BaseSubscriptionJob
{

    public function handle(): void
    {
        $this->getSubscription()->subscriptionPastDue($this->gatewaySubscription['next_billing_date']);
    }
}
