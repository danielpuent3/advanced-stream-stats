## Advanced Stream Stats

### Stack

- Laravel
- Vue
- Sail (docker)
- Pest PHP (testing)

### Setup

Tested is done in Laravel Sail. You'll need to have docker and Laravel sail installed. https://laravel.com/docs/master/sail

## Spinning up app

`./vendor/bin/sail up`



### Testing

PestPHP is used as the framework to test for the app

## Running test suite

`./vendor/bin/sail artisan test`

> Function test creating subscription through braintree has a caveat. There is duplicate checking in place through braintree. If tests are run within 30 seconds of each other there will be an error thrown on the function test for creating a subscription. Simply wait 30 seconds before executing test sutie again.
