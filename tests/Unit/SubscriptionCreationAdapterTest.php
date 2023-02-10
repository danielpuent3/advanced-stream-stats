<?php

use App\Adapters\Braintree\SubscriptionCreationAdapter;
use Braintree\Gateway;
use Braintree\Subscription;
use Braintree\SubscriptionGateway;
use Tests\TestCase;

uses(TestCase::class);

test('SubscriptionCreationAdapterTest', function () {
    $gateway = mock(Gateway::class)->expect(subscription: function () {
        return mock(SubscriptionGateway::class)->shouldReceive('create')->with([
            'paymentMethodToken' => 'a-payment-method-token',
            'planId' => 'a-plan-id'
        ])->andReturn(
            new Braintree\Result\Successful(
                Subscription::factory([])
            )
        )->getMock();
    });

    $subscription = app(SubscriptionCreationAdapter::class)->create($gateway, 'a-payment-method-token', 'a-plan-id');

    expect($subscription)->toBeInstanceOf(Braintree\Subscription::class);
});
