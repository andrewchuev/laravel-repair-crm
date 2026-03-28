<?php

namespace App\Modules\Documents\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentNumberCounter extends Model
{
    protected $fillable = ['document_type', 'year', 'prefix', 'last_number'];
}
