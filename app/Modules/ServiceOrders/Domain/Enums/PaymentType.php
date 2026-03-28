<?php

namespace App\Modules\ServiceOrders\Domain\Enums;

enum PaymentType: string
{
    case PAYMENT = 'payment';
    case REFUND = 'refund';


public function label(): string
{
    return __('payments.types.' . $this->value);
}

public static function values(): array
{
    return array_column(self::cases(), 'value');
}
}
