<?php

namespace App\Jobs;

class SubscriptionExpiredJob extends BaseSubscriptionJob
{

    public function handle(): void
    {
        $this->getSubscription()->subscriptionExpired();
    }
}
