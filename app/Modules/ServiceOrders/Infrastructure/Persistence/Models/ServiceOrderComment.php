<?php

namespace App\Modules\ServiceOrders\Infrastructure\Persistence\Models;

use App\Models\User;
use App\Modules\ServiceOrders\Domain\Enums\CommentVisibility;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceOrderComment extends Model
{
    protected $fillable = [
        'service_order_id',
        'user_id',
        'visibility',
        'body',
    ];

    protected function casts(): array
    {
        return [
            'visibility' => CommentVisibility::class,
        ];
    }

    public function serviceOrder(): BelongsTo
    {
        return $this->belongsTo(ServiceOrder::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
