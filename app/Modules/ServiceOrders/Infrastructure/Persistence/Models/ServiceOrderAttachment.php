<?php

namespace App\Modules\ServiceOrders\Infrastructure\Persistence\Models;

use App\Models\User;
use App\Modules\ServiceOrders\Domain\Enums\AttachmentType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class ServiceOrderAttachment extends Model
{
    protected $fillable = [
        'service_order_id',
        'uploaded_by_user_id',
        'type',
        'original_name',
        'stored_name',
        'disk',
        'path',
        'mime_type',
        'extension',
        'size_bytes',
        'checksum',
        'description',
        'is_primary',
        'taken_at',
        'meta',
    ];

    protected function casts(): array
    {
        return [
            'type' => AttachmentType::class,
            'is_primary' => 'boolean',
            'taken_at' => 'datetime',
            'meta' => 'array',
        ];
    }

    public function serviceOrder(): BelongsTo
    {
        return $this->belongsTo(ServiceOrder::class);
    }

    public function uploadedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by_user_id');
    }

    public function isImage(): bool
    {
        return str_starts_with($this->mime_type, 'image/');
    }

    public function url(): string
    {
        return Storage::disk($this->disk)->url($this->path);
    }
}
