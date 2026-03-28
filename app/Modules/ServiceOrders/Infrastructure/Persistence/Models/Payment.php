<?php

namespace App\Modules\ServiceOrders\Infrastructure\Persistence\Models;

use App\Models\User;
use App\Modules\ServiceOrders\Domain\Enums\PaymentMethod;
use App\Modules\ServiceOrders\Domain\Enums\PaymentType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'service_order_id',
        'type',
        'method',
        'amount',
        'paid_at',
        'comment',
        'created_by_user_id',
    ];

    protected function casts(): array
    {
        return [
            'type' => PaymentType::class,
            'method' => PaymentMethod::class,
            'amount' => 'decimal:2',
            'paid_at' => 'datetime',
        ];
    }

    public function serviceOrder(): BelongsTo
    {
        return $this->belongsTo(ServiceOrder::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }
}
