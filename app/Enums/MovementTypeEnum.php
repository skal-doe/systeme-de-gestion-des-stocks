<?php

namespace App\Enums;

enum MovementTypeEnum: string
{
    case IN = 'in';
    case OUT = 'out';

    public static function labels(): array
    {
        return [
            self::IN->value => 'Entrée',
            self::OUT->value => 'Sortie',
        ];
    }

    public function getLabel(): string
    {
        return match($this) {
            self::IN => 'Entrée',
            self::OUT => 'Sortie',
        };
    }
}
