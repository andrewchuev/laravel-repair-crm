<?php

namespace App\Modules\ServiceOrders\Infrastructure\Persistence\Models;

use App\Models\User;
use App\Modules\ServiceOrders\Domain\Enums\ServiceOrderStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceOrderStatusHistory extends Model
{
    public $timestamps = false;

    protected $table = 'service_order_status_history';
    protected $fillable = [
        'service_order_id',
        'old_status',
        'new_status',
        'comment',
        'changed_by_user_id',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'old_status' => ServiceOrderStatus::class,
            'new_status' => ServiceOrderStatus::class,
            'created_at' => 'datetime',
        ];
    }

    public function serviceOrder(): BelongsTo
    {
        return $this->belongsTo(ServiceOrder::class);
    }

    public function changedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by_user_id');
    }
}
