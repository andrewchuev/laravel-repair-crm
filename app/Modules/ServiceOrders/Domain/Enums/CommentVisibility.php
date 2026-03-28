<?php

namespace App\Modules\ServiceOrders\Domain\Enums;

enum CommentVisibility: string
{
    case INTERNAL = 'internal';
    case PUBLIC = 'public';


public function label(): string
{
    return __('service_orders.comment_visibility.' . $this->value);
}

public static function values(): array
{
    return array_column(self::cases(), 'value');
}
}
