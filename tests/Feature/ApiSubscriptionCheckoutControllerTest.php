<?php

use App\Models\Subscription;
use App\Models\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

use Tests\TestCase;

use function Pest\Laravel\postJson;
use function Pest\Laravel\actingAs;

uses(TestCase::class);

uses(RefreshDatabase::class);

beforeEach(fn() => $this->user = User::factory()->create());

test('a monthly subscription is successfully created', function () {
    $response = actingAs($this->user)->postJson(
        '/api/subscriptions/create',
        ['plan' => 'monthly', 'nonce' => 'fake-valid-nonce']
    );

    $response->assertStatus(201);
});

test('a yearly subscription is successfully created', function () {
    $response = actingAs($this->user)->postJson(
        '/api/subscriptions/create',
        ['plan' => 'yearly', 'nonce' => 'fake-valid-nonce']
    );

    $response->assertStatus(201);
});

test('checkout requires an authenticated user to create a subscription', function () {
    $response = postJson('/api/subscriptions/create', []);

    $response->assertStatus(HttpResponse::HTTP_UNAUTHORIZED);
});

test('users with an active subscription cannot checkout', function () {
    Subscription::factory()->active_monthly()->create(['user_id' => $this->user->id]);

    $response = actingAs($this->user)->postJson('/api/subscriptions/create', []);

    $response->assertStatus(HttpResponse::HTTP_FORBIDDEN);
});

test('a valid plan is required', function () {
    $response = actingAs($this->user)->postJson('/api/subscriptions/create', ['plan' => 'a-wrong-plan']);

    $response->assertStatus(HttpResponse::HTTP_UNPROCESSABLE_ENTITY);
    $response->assertJsonValidationErrorFor('plan');
});

test('a nonce is required', function () {
    $response = actingAs($this->user)->postJson('/api/subscriptions/create', ['plan' => 'monthly']);

    $response->assertStatus(HttpResponse::HTTP_UNPROCESSABLE_ENTITY);
    $response->assertJsonValidationErrorFor('nonce');
});


