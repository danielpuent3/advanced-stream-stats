<?php

namespace App\Jobs;

use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

abstract class BaseSubscriptionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected ?Subscription $subscription;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(protected string $subscriptionId, protected array $gatewaySubscription)
    {
    }

    protected function getSubscription(): Subscription
    {
        if (!$this->subscription) {
            $this->subscription = Subscription::findOrFail($this->subscriptionId);
        }

        return $this->subscription;
    }

    abstract public function handle();
}
