<?php


use App\Adapters\Braintree\PaymentMethodCreationAdapter;
use App\Adapters\Braintree\SubscriptionCreationAdapter;
use App\Models\User;
use Braintree\PaymentMethodParser;
use Tests\TestCase;

uses(TestCase::class);

test('SubscriptionServiceTest create', function () {
    $user = User::factory()->create();

    $this->app->bind(PaymentMethodCreationAdapter::class, function () {
        return mock(PaymentMethodCreationAdapter::class)
            ->shouldReceive('create')
            ->andReturn(
                (new Braintree\Result\Successful(
                    PaymentMethodParser::parsePaymentMethod(['creditCard' => ['token' => 'a-token']]),
                    'paymentMethod'
                ))->paymentMethod
            )
            ->getMock();
    });

    $this->app->bind(SubscriptionCreationAdapter::class, function () {
        return mock(SubscriptionCreationAdapter::class)
            ->shouldReceive('create')
            ->andReturn(
                (new Braintree\Result\Successful(
                    Braintree\Subscription::factory([
                        'firstBillingDate' => now(),
                        'nextBillingDate' => now()->addMonth(),
                    ])
                ))->subscription
            )
            ->getMock();
    });

    $subscription = app(\App\Services\SubscriptionService::class)->create($user, 'a-nonce', 'monthly');

    expect($subscription)->toBeInstanceOf(\App\Models\Subscription::class);
    expect($subscription->status)->toBe(\App\Models\Subscription::ACTIVE);
    expect($subscription->price)->toBe(config('plans.monthly.price'));
});
