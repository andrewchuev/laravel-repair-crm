<?php

namespace App\Modules\Documents\Domain\Enums;

enum DocumentStatus: string
{
    case DRAFT = 'draft';
    case ISSUED = 'issued';
    case VOID = 'void';
}
