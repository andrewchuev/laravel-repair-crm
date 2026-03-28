<?php

namespace App\Modules\Settings\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentPreference extends Model
{
    protected $fillable = [
        'business_profile_id', 'invoice_prefix', 'intake_act_prefix', 'completion_act_prefix',
        'default_document_locale', 'repair_terms_uk', 'storage_terms_uk', 'diagnostic_terms_uk',
        'warranty_terms_uk', 'invoice_footer_uk', 'completion_act_footer_uk',
    ];

    public function businessProfile(): BelongsTo
    {
        return $this->belongsTo(BusinessProfile::class);
    }
}
