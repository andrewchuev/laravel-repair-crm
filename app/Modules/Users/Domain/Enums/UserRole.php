<?php

namespace App\Modules\Users\Domain\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case MANAGER = 'manager';
    case MASTER = 'master';


public function label(): string
{
    return __('users.roles.' . $this->value);
}

public static function values(): array
{
    return array_column(self::cases(), 'value');
}
}
