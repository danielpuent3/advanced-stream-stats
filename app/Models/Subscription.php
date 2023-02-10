<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subscription extends Model
{

    use HasFactory;

    public const ACTIVE = 'Active';

    public const CANCELED = 'Canceled';

    public const EXPIRED = 'Expired';

    public const PAST_DUE = 'Past Due';

    public $fillable = [
        'external_subscription_id',
        'payment_method_token',
        'active',
        'status',
        'plan_id',
        'interval',
        'price',
        'starts_at',
        'next_billing_at',
        'ends_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(SubscriptionPayments::class);
    }

    public function successfulPayment($nextBillingDate): bool
    {
        return $this->update([
            'active' => true,
            'status' => self::ACTIVE,
            'next_billing_at' => $nextBillingDate,
        ]);
    }

    public function cancelSubscription(): bool
    {
        return $this->update([
            'active' => false,
            'status' => self::CANCELED,
        ]);
    }

    public function subscriptionExpired(): bool
    {
        return $this->update([
            'active' => false,
            'status' => self::EXPIRED,
        ]);
    }

    public function subscriptionPastDue($nextBillingDate): bool
    {
        return $this->update([
            'active' => false,
            'status' => self::PAST_DUE,
            'next_billing_at' => $nextBillingDate,
        ]);
    }

    public static function statuses(): array
    {
        return [
            self::ACTIVE,
            self::CANCELED,
            self::EXPIRED,
            self::PAST_DUE,
        ];
    }
}
