<?php

namespace App\Modules\Settings\Infrastructure\Persistence\Models;

use App\Modules\Documents\Infrastructure\Persistence\Models\GeneratedDocument;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BusinessProfile extends Model
{
    protected $fillable = [
        'legal_name','short_name','tax_id','registration_number','vat_number','default_locale',
        'phone','email','website','registration_address','actual_address','city','postal_code',
        'signer_name','signer_title','logo_path','is_active',
    ];

    protected $casts = ['is_active' => 'bool'];

    public function bankAccounts(): HasMany
    {
        return $this->hasMany(BankAccount::class);
    }

    public function documentSetting(): HasOne
    {
        return $this->hasOne(DocumentSetting::class);
    }

    public function generatedDocuments(): HasMany
    {
        return $this->hasMany(GeneratedDocument::class);
    }
}
