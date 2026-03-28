<?php

namespace App\Modules\ServiceOrders\Domain\Enums;

enum AttachmentType: string
{
    case INTAKE_PHOTO = 'intake_photo';
    case DAMAGE_PHOTO = 'damage_photo';
    case SERIAL_PHOTO = 'serial_photo';
    case DIAGNOSTIC_PHOTO = 'diagnostic_photo';
    case REPAIR_PHOTO = 'repair_photo';
    case FINAL_PHOTO = 'final_photo';
    case DOCUMENT = 'document';
    case RECEIPT = 'receipt';
    case WARRANTY = 'warranty';
    case OTHER = 'other';


public function label(): string
{
    return __('attachments.types.' . $this->value);
}

public static function values(): array
{
    return array_column(self::cases(), 'value');
}
}
