<?php

namespace App\Services;

use App\Adapters\Braintree\PaymentMethodCreationAdapter;
use App\Adapters\Braintree\SubscriptionCancelationAdapter;
use App\Adapters\Braintree\SubscriptionCreationAdapter;
use App\Models\Subscription;
use App\Models\User;
use Braintree\Gateway;
use Exception;

class SubscriptionService
{
    public function __construct(
        private Gateway $gateway,
        private PaymentMethodCreationAdapter $paymentMethodCreationAdapter,
        private SubscriptionCreationAdapter $subscriptionCreationAdapter,
        private SubscriptionCancelationAdapter $subscriptionCancelationAdapter,
    ) {
    }

    /**
     * @throws Exception
     */
    public function create(User $user, string $nonce, string $planId)
    {
        $paymentMethod = $this->paymentMethodCreationAdapter->create($this->gateway, $nonce);

        $gatewaySubscription = $this->subscriptionCreationAdapter->create(
            $this->gateway,
            $paymentMethod->token,
            $planId
        );

        return $user->subscriptions()->create([
            'active' => true,
            'external_subscription_id' => $gatewaySubscription->id,
            'payment_method_token' => $gatewaySubscription->paymentMethodToken,
            'status' => Subscription::ACTIVE,
            'plan_id' => $planId,
            'interval' => config("plans.$planId.interval"),
            'price' => config("plans.$planId.price"),
            'starts_at' => $gatewaySubscription->firstBillingDate,
            'next_billing_at' => $gatewaySubscription->nextBillingDate,
        ]);
    }

    /**
     * @throws Exception
     */
    public function cancel(Subscription $subscription)
    {
        $gatewaySubscription = $this->subscriptionCancelationAdapter->cancel($this->gateway, $subscription);

        $subscription->update([
            'ends_at' => $gatewaySubscription->billingPeriodEndDate,
        ]);

        return $subscription->fresh();
    }
}
