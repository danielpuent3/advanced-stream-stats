<?php

namespace App\Http\Controllers\Webhooks;

use App\Adapters\Braintree\WebhookParserAdapter;
use App\Http\Controllers\Controller;
use App\Jobs\SubscriptionCanceledJob;
use App\Jobs\SubscriptionExpiredJob;
use App\Jobs\SubscriptionPastDueJob;
use App\Jobs\SubscriptionPaymentSuccessJob;
use App\Jobs\SubscriptionPaymentFailedJob;
use Braintree\Gateway;
use Braintree\WebhookNotification;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class BraintreeWebhooksController extends Controller
{
    use DispatchesJobs;

    public function __construct(
        private Gateway $gateway,
        private WebhookParserAdapter $webhookParserAdapter,
    ) {
    }

    public function subscriptions(Request $request): JsonResponse
    {
        $response = $this->webhookParserAdapter->parse(
            $this->gateway,
            $request->input('bt_signature'),
            $request->input('bt_payload')
        );

        $kind = $response->kind;
        $subject = $response->subject;

        $gatewaySubscription = Arr::get($subject, 'subscription');
        $subscriptionId = Arr::get($gatewaySubscription, 'id');

        Log::info('Processing webhook for subscription_id', [
            'subscription_id' => $subscriptionId,
            'kind' => $kind,
            'bt_signature' => $request->input('bt_signature'),
            'bt_payload' => $request->input('bt_payload')
        ]);

        $job = match ($kind) {
            WebhookNotification::SUBSCRIPTION_CHARGED_SUCCESSFULLY => SubscriptionPaymentSuccessJob::class,
            WebhookNotification::SUBSCRIPTION_CHARGED_UNSUCCESSFULLY => SubscriptionPaymentFailedJob::class,
            WebhookNotification::SUBSCRIPTION_CANCELED => SubscriptionCanceledJob::class,
            WebhookNotification::SUBSCRIPTION_EXPIRED => SubscriptionExpiredJob::class,
            WebhookNotification::SUBSCRIPTION_WENT_PAST_DUE => SubscriptionPastDueJob::class,
        };

        $this->dispatch(new $job($subscriptionId, $gatewaySubscription));

        return response()->json();
    }
}
