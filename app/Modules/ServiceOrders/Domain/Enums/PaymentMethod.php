<?php

namespace App\Modules\ServiceOrders\Domain\Enums;

enum PaymentMethod: string
{
    case CASH = 'cash';
    case CARD = 'card';
    case BANK_TRANSFER = 'bank_transfer';
    case OTHER = 'other';


public function label(): string
{
    return __('payments.methods.' . $this->value);
}

public static function values(): array
{
    return array_column(self::cases(), 'value');
}
}
