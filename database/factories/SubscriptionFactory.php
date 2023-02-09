<?php

namespace Database\Factories;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subscription>
 */
class SubscriptionFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'starts_at' => now()->startOfDay(),
            'external_subscription_id' => 'a-subscription-id',
            'payment_method_token' => 'a-payment-method-token',
        ];
    }

    public function active_monthly(): SubscriptionFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => Subscription::ACTIVE,
                'active' => true,
                'plan_id' => config('plans.monthly.id'),
                'interval' => 'monthly',
                'price' => config('plans.monthly.price'),
                'next_billing_at' => now()->startOfDay()->addMonth(),
            ];
        });
    }

    public function active_yearly(): SubscriptionFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => Subscription::ACTIVE,
                'active' => true,
                'plan_id' => config('plans.yearly.id'),
                'interval' => 'yearly',
                'price' => config('plans.yearly.price'),
                'starts_at' => now()->startOfDay(),
                'next_billing_at' => now()->startOfDay()->addYear(),
            ];
        });
    }

    public function canceled(): SubscriptionFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => Subscription::CANCELED,
                'active' => false,
            ];
        });
    }

    public function expired(): SubscriptionFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => Subscription::EXPIRED,
                'active' => false,
            ];
        });
    }

    public function past_due(): SubscriptionFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => Subscription::PAST_DUE,
                'active' => false,
            ];
        });
    }

    public function monthly(): SubscriptionFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'plan_id' => config('plans.monthly.id'),
                'interval' => 'monthly',
                'price' => config('plans.monthly.price'),
            ];
        });
    }

    public function yearly(): SubscriptionFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'plan_id' => config('plans.yearly.id'),
                'interval' => 'yearly',
                'price' => config('plans.yearly.price'),
            ];
        });
    }
}
