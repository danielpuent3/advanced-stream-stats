<?php

use App\Adapters\Braintree\PaymentMethodCreationAdapter;
use Braintree\Customer;
use Braintree\CustomerGateway;
use Braintree\Gateway;
use Braintree\PaymentMethodGateway;
use Braintree\PaymentMethodParser;
use Tests\TestCase;

uses(TestCase::class);

test('PaymentMethodCreationAdapterTest', function () {
    $gateway = mock(Gateway::class)->expect(customer: function () {
        return mock(CustomerGateway::class)->shouldReceive('create')->andReturn(
            new Braintree\Result\Successful(Customer::factory(['id' => 'a-customer-id']))
        )->getMock();
    }, paymentMethod: function () {
        return mock(PaymentMethodGateway::class)->shouldReceive('create')->with([
            'customerId' => 'a-customer-id',
            'paymentMethodNonce' => 'a-payment-method-nonce'
        ])->andReturn(
            new Braintree\Result\Successful(
                PaymentMethodParser::parsePaymentMethod(['creditCard' => ['token' => 'a-token']]),
                'paymentMethod'
            )
        )->getMock();
    });

    $paymentMethod = app(PaymentMethodCreationAdapter::class)->create($gateway, 'a-payment-method-nonce');

    expect($paymentMethod)->toBeInstanceOf(Braintree\CreditCard::class);
    expect($paymentMethod->token)->toBe('a-token');
});
