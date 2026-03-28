<?php

namespace App\Modules\Documents\Domain\Enums;

enum GeneratedDocumentStatus: string
{
    case Draft = 'draft';
    case Issued = 'issued';
    case Voided = 'voided';
}
