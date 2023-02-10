<?php

namespace App\Http\Controllers;

use App\Services\GraphQL\BraintreeGraphQLService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CartController extends Controller
{
    public function __construct(private BraintreeGraphQLService $braintreeGQL)
    {
    }

    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return \Inertia\Response
     */
    public function __invoke(Request $request)
    {
        $credentials = [
            'clientToken' => $this->braintreeGQL->clientToken(),
            'merchantId' => config('services.braintree.merchant_id')
        ];

        return Inertia::render('Subscribe', [
            'clientToken' => $this->braintreeGQL->clientToken(),
            'credentials' => $credentials,
            'pricing' => config('pricing'),
        ]);
    }
}
