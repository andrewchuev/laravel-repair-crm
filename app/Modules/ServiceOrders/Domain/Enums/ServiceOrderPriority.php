<?php

namespace App\Modules\ServiceOrders\Domain\Enums;

enum ServiceOrderPriority: string
{
    case LOW = 'low';
    case NORMAL = 'normal';
    case HIGH = 'high';
    case URGENT = 'urgent';


public function label(): string
{
    return __('service_orders.priority.' . $this->value);
}

public static function values(): array
{
    return array_column(self::cases(), 'value');
}
}
