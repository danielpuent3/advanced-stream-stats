<?php declare(strict_types=1);

namespace App\Services\GraphQL;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class BraintreeGraphQLService
{

    public const VERSION = '2023-02-06';

    public function clientToken(): string
    {
        $mutation = "mutation {
                createClientToken {
                    clientToken
                }
            }";

        return $this->http()->post($this->url(), [
            'query' => $mutation,
        ])->collect('data.createClientToken.clientToken')->first();
    }

    private function http(): PendingRequest
    {
        return Http::withToken($this->bearerToken())->withHeaders([
            'Braintree-Version' => static::VERSION,
            'Content-Type' => 'application/json'
        ]);
    }

    private function bearerToken(): string
    {
        $publicKey = config('services.braintree.public_key');
        $privateKey = config('services.braintree.private_key');
        return base64_encode("{$publicKey}:{$privateKey}");
    }

    private function url(): string
    {
        return config('services.braintree.graphql_url');
    }
}
