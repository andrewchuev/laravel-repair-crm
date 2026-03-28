<?php

namespace App\Modules\Clients\Domain\Enums;

enum ClientType: string
{
    case PERSON = 'person';
    case COMPANY = 'company';


public function label(): string
{
    return __('clients.types.' . $this->value);
}

public static function values(): array
{
    return array_column(self::cases(), 'value');
}
}
