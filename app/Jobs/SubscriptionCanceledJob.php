<?php

namespace App\Jobs;

class SubscriptionCanceledJob extends BaseSubscriptionJob
{

    public function handle(): void
    {
        $this->getSubscription()->cancelSubscription();
    }
}
