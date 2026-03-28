<?php

namespace App\Modules\ServiceOrders\Domain\Enums;

enum ServiceOrderCategory: string
{
    case COMPUTER = 'computer';
    case LAPTOP = 'laptop';
    case PRINTER = 'printer';
    case MFP = 'mfp';
    case CARTRIDGE = 'cartridge';
    case MONITOR = 'monitor';
    case NETWORK = 'network';
    case OTHER = 'other';


public function label(): string
{
    return __('service_orders.category.' . $this->value);
}

public static function values(): array
{
    return array_column(self::cases(), 'value');
}
}
