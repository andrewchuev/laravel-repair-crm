<?php

namespace App\Modules\Settings\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentSetting extends Model
{
    protected $fillable = [
        'business_profile_id','document_locale','invoice_prefix','intake_act_prefix','completion_act_prefix',
        'warranty_prefix','number_format','default_city','invoice_footer','intake_terms',
        'completion_terms','warranty_terms','storage_terms',
    ];

    public function businessProfile(): BelongsTo
    {
        return $this->belongsTo(BusinessProfile::class);
    }
}
