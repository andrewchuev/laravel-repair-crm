<?php

namespace App\Models;

use App\Modules\Clients\Infrastructure\Persistence\Models\Client;
use App\Modules\Documents\Infrastructure\Persistence\Models\GeneratedDocument;
use App\Modules\ServiceOrders\Infrastructure\Persistence\Models\Payment;
use App\Modules\ServiceOrders\Infrastructure\Persistence\Models\ServiceOrder;
use App\Modules\ServiceOrders\Infrastructure\Persistence\Models\ServiceOrderAttachment;
use App\Modules\ServiceOrders\Infrastructure\Persistence\Models\ServiceOrderComment;
use App\Modules\Users\Domain\Enums\UserRole;
use App\Shared\Domain\Enums\SupportedLocale;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'is_active',
        'preferred_locale',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
            'is_active' => 'boolean',
            'preferred_locale' => SupportedLocale::class,
        ];
    }

    public function createdClients(): HasMany
    {
        return $this->hasMany(Client::class, 'created_by_user_id');
    }

    public function acceptedServiceOrders(): HasMany
    {
        return $this->hasMany(ServiceOrder::class, 'accepted_by_user_id');
    }

    public function assignedServiceOrders(): HasMany
    {
        return $this->hasMany(ServiceOrder::class, 'assigned_master_id');
    }

    public function serviceOrderComments(): HasMany
    {
        return $this->hasMany(ServiceOrderComment::class, 'user_id');
    }

    public function uploadedAttachments(): HasMany
    {
        return $this->hasMany(ServiceOrderAttachment::class, 'uploaded_by_user_id');
    }

    public function recordedPayments(): HasMany
    {
        return $this->hasMany(Payment::class, 'created_by_user_id');
    }

    public function generatedDocuments(): HasMany
    {
        return $this->hasMany(GeneratedDocument::class, 'generated_by_user_id');
    }
}
