<?php

namespace App\Modules\ServiceOrders\Domain\Enums;

enum ServiceOrderItemType: string
{
    case WORK = 'work';
    case PART = 'part';


public function label(): string
{
    return __('service_orders.item_types.' . $this->value);
}

public static function values(): array
{
    return array_column(self::cases(), 'value');
}
}
