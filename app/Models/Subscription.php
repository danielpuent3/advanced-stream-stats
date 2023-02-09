<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subscription extends Model
{

    use HasFactory;

    const ACTIVE = 'Active';

    const CANCELED = 'Canceled';

    const EXPIRED = 'Expired';

    const PAST_DUE = 'Past Due';

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
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(SubscriptionPayments::class);
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
