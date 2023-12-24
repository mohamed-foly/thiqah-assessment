<?php

namespace App\Enums;

enum UserType: int
{
    case Normal = 1;
    case Gold = 2;
    case Silver = 3;

    public static function values(): array
    {
        return array_map(fn ($case) => $case->value, self::cases());
    }

    public static function getStringValue(int $enumValue): ?string
    {
        foreach (self::cases() as $case) {
            if ($case->value === $enumValue) {
                return $case->name;
            }
        }
        return null;
    }
}
