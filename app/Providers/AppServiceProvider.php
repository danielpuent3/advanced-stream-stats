<?php

namespace App\Providers;

use Braintree\Gateway;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            Gateway::class,
            function () {
                return new Gateway([
                    'environment' => 'sandbox',
                    'merchantId' => config('services.braintree.merchant_id'),
                    'publicKey' => config('services.braintree.public_key'),
                    'privateKey' => config('services.braintree.private_key')
                ]);
            }
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
