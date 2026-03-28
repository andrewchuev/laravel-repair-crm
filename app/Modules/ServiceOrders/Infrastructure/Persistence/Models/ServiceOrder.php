<?php

namespace App\Modules\ServiceOrders\Infrastructure\Persistence\Models;

use App\Models\User;
use App\Modules\Clients\Infrastructure\Persistence\Models\Client;
use App\Modules\Documents\Infrastructure\Persistence\Models\GeneratedDocument;
use App\Modules\ServiceOrders\Domain\Enums\ServiceOrderCategory;
use App\Modules\ServiceOrders\Domain\Enums\ServiceOrderPriority;
use App\Modules\ServiceOrders\Domain\Enums\ServiceOrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'client_id',
        'accepted_by_user_id',
        'assigned_master_id',
        'status',
        'priority',
        'category',
        'item_name',
        'brand',
        'model',
        'serial_number',
        'reported_problem',
        'intake_condition',
        'accessories',
        'intake_checklist',
        'device_snapshot',
        'diagnostic_summary',
        'work_result',
        'internal_notes',
        'customer_notes',
        'estimated_price',
        'agreed_price',
        'final_price',
        'paid_amount',
        'balance_amount',
        'received_at',
        'promised_at',
        'approved_at',
        'ready_at',
        'delivered_at',
        'warranty_until',
        'cancelled_at',
        'cancellation_reason',
    ];

    protected function casts(): array
    {
        return [
            'status' => ServiceOrderStatus::class,
            'priority' => ServiceOrderPriority::class,
            'category' => ServiceOrderCategory::class,
            'intake_checklist' => 'array',
            'device_snapshot' => 'array',
            'estimated_price' => 'decimal:2',
            'agreed_price' => 'decimal:2',
            'final_price' => 'decimal:2',
            'paid_amount' => 'decimal:2',
            'balance_amount' => 'decimal:2',
            'received_at' => 'datetime',
            'promised_at' => 'datetime',
            'approved_at' => 'datetime',
            'ready_at' => 'datetime',
            'delivered_at' => 'datetime',
            'warranty_until' => 'date',
            'cancelled_at' => 'datetime',
        ];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function acceptedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'accepted_by_user_id');
    }

    public function assignedMaster(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_master_id');
    }

    public function statusHistory(): HasMany
    {
        return $this->hasMany(ServiceOrderStatusHistory::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(ServiceOrderItem::class)->orderBy('position');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(ServiceOrderComment::class)->latest();
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(ServiceOrderAttachment::class)->latest();
    }

    public function documents(): HasMany
    {
        return $this->hasMany(GeneratedDocument::class)->latest('created_at');
    }

    public function canTransitionTo(ServiceOrderStatus $to): bool
    {
        return match ($this->status) {
            ServiceOrderStatus::NEW => in_array($to, [
                ServiceOrderStatus::DIAGNOSTICS,
                ServiceOrderStatus::CANCELLED,
            ], true),
            ServiceOrderStatus::DIAGNOSTICS => in_array($to, [
                ServiceOrderStatus::AWAITING_APPROVAL,
                ServiceOrderStatus::IN_PROGRESS,
                ServiceOrderStatus::CANCELLED,
            ], true),
            ServiceOrderStatus::AWAITING_APPROVAL => in_array($to, [
                ServiceOrderStatus::APPROVED,
                ServiceOrderStatus::CANCELLED,
            ], true),
            ServiceOrderStatus::APPROVED => in_array($to, [
                ServiceOrderStatus::IN_PROGRESS,
                ServiceOrderStatus::WAITING_PARTS,
                ServiceOrderStatus::CANCELLED,
            ], true),
            ServiceOrderStatus::IN_PROGRESS => in_array($to, [
                ServiceOrderStatus::WAITING_PARTS,
                ServiceOrderStatus::READY,
                ServiceOrderStatus::CANCELLED,
            ], true),
            ServiceOrderStatus::WAITING_PARTS => in_array($to, [
                ServiceOrderStatus::IN_PROGRESS,
                ServiceOrderStatus::READY,
                ServiceOrderStatus::CANCELLED,
            ], true),
            ServiceOrderStatus::READY => in_array($to, [
                ServiceOrderStatus::DELIVERED,
            ], true),
            ServiceOrderStatus::DELIVERED,
            ServiceOrderStatus::CANCELLED => false,
        };
    }

    public function isEditable(): bool
    {
        return ! in_array($this->status, [
            ServiceOrderStatus::DELIVERED,
            ServiceOrderStatus::CANCELLED,
        ], true);
    }

    public function generatedDocuments(): HasMany
    {
        return $this->hasMany(\App\Modules\Documents\Infrastructure\Persistence\Models\GeneratedDocument::class);
    }

}
