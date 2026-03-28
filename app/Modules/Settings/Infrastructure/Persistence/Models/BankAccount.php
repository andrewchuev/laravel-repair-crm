<?php

namespace App\Modules\Settings\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BankAccount extends Model
{
    protected $fillable = [
        'business_profile_id','title','recipient','iban','bank_name','bank_mfo','bank_edrpou',
        'currency','payment_purpose_template','is_default','is_active',
    ];

    protected $casts = ['is_default' => 'bool', 'is_active' => 'bool'];

    public function businessProfile(): BelongsTo
    {
        return $this->belongsTo(BusinessProfile::class);
    }
}
