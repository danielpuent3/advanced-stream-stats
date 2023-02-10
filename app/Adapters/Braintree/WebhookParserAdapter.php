<?php

namespace App\Adapters\Braintree;

use Braintree\Gateway;
use Braintree\WebhookNotification;

class WebhookParserAdapter
{
    /**
     * @throws \Braintree\Exception\InvalidSignature
     */
    public function parse(Gateway $gateway, string $signature, string $payload): WebhookNotification
    {
        return $gateway->webhookNotification()->parse($signature, $payload);
    }
}
