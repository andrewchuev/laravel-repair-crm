<?php

namespace App\Modules\Clients\Infrastructure\Persistence\Models;

use App\Models\User;
use App\Modules\Clients\Domain\Enums\ClientType;
use App\Modules\ServiceOrders\Infrastructure\Persistence\Models\ServiceOrder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'type',
        'full_name',
        'company_name',
        'phone',
        'phone_secondary',
        'email',
        'notes',
        'source',
        'created_by_user_id',
    ];

    protected function casts(): array
    {
        return [
            'type' => ClientType::class,
            'deleted_at' => 'datetime',
        ];
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function serviceOrders(): HasMany
    {
        return $this->hasMany(ServiceOrder::class);
    }

    public function getDisplayNameAttribute(): string
    {
        $type = $this->type?->value ?? $this->type;

        return match ($type) {
            'person' => (string) ($this->full_name ?? ''),
            'company' => (string) ($this->company_name ?? ''),
            default => (string) ($this->full_name ?: $this->company_name ?: ''),
        };
    }

    public function displayName(): string
    {
        return $this->display_name;
    }
}
