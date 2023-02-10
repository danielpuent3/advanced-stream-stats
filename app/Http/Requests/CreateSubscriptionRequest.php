<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class CreateSubscriptionRequest extends FormRequest
{

    /**
     * Users with subscriptions are not authorized to create subscriptions
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return !$this->user()->hasActiveSubscription();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'plan' => [
                'bail',
                Rule::in(Arr::pluck(config('plans'), 'id'))
            ],
            'nonce' => 'required',
        ];
    }
}
