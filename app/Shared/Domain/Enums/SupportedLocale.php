<?php

namespace App\Shared\Domain\Enums;

enum SupportedLocale: string
{
    case EN = 'en';
    case RU = 'ru';
    case UK = 'uk';


public function label(): string
{
    return __('common.locales.' . $this->value);
}

public static function values(): array
{
    return array_column(self::cases(), 'value');
}
}
