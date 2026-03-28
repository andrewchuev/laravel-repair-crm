<?php

namespace App\Modules\ServiceOrders\Domain\Enums;

enum ServiceOrderStatus: string
{
    case NEW = 'new';
    case DIAGNOSTICS = 'diagnostics';
    case AWAITING_APPROVAL = 'awaiting_approval';
    case APPROVED = 'approved';
    case IN_PROGRESS = 'in_progress';
    case WAITING_PARTS = 'waiting_parts';
    case READY = 'ready';
    case DELIVERED = 'delivered';
    case CANCELLED = 'cancelled';


public function label(): string
{
    return __('service_orders.status.' . $this->value);
}

public static function values(): array
{
    return array_column(self::cases(), 'value');
}
}
