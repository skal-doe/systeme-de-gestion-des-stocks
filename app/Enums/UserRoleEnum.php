<?php

namespace App\Enums;

enum UserRoleEnum: string
{
    case ADMIN = 'admin';
    case MANAGER = 'manager';
    case COMMERCIAL = 'commercial';

    public static function labels(): array
    {
        return [
            self::ADMIN->value => 'Administrateur',
            self::MANAGER->value => 'Gestionnaire de stocks',
            self::COMMERCIAL->value => 'Commercial',
        ];
    }

    public static function options(): array
    {
        return array_map(fn($value, $label) => [
            'value' => $value,
            'label' => $label
        ], array_keys(self::labels()), array_values(self::labels()));
    }
}
