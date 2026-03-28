<?php

namespace App\Modules\Documents\Infrastructure\Persistence\Models;

use App\Modules\Settings\Infrastructure\Persistence\Models\BusinessProfile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentCounter extends Model
{
    protected $fillable = ['business_profile_id', 'document_type', 'year', 'current_number'];

    public function businessProfile(): BelongsTo
    {
        return $this->belongsTo(BusinessProfile::class);
    }
}
