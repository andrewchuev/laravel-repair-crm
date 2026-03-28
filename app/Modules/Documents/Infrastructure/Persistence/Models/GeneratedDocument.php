<?php

namespace App\Modules\Documents\Infrastructure\Persistence\Models;

use App\Models\User;
use App\Modules\Documents\Domain\Enums\DocumentType;
use App\Modules\Documents\Domain\Enums\GeneratedDocumentStatus;
use App\Modules\ServiceOrders\Infrastructure\Persistence\Models\ServiceOrder;
use App\Modules\Settings\Infrastructure\Persistence\Models\BankAccount;
use App\Modules\Settings\Infrastructure\Persistence\Models\BusinessProfile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GeneratedDocument extends Model
{
    protected $fillable = [
        'service_order_id','business_profile_id','bank_account_id','document_type','document_number',
        'document_date','locale','status','snapshot_json','html_disk','html_path','pdf_disk','pdf_path',
        'issued_by_user_id','voided_by_user_id','void_reason','issued_at','voided_at',
    ];

    protected $casts = [
        'document_type' => DocumentType::class,
        'status' => GeneratedDocumentStatus::class,
        'document_date' => 'date',
        'snapshot_json' => 'array',
        'issued_at' => 'datetime',
        'voided_at' => 'datetime',
    ];

    public function serviceOrder(): BelongsTo
    {
        return $this->belongsTo(ServiceOrder::class);
    }

    public function businessProfile(): BelongsTo
    {
        return $this->belongsTo(BusinessProfile::class);
    }

    public function bankAccount(): BelongsTo
    {
        return $this->belongsTo(BankAccount::class);
    }

    public function issuedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'issued_by_user_id');
    }

    public function voidedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'voided_by_user_id');
    }
}
