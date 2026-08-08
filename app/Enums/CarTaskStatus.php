<?php

namespace App\Enums;

enum CarTaskStatus: string
{
    case PENDING = 'pending';
    case COMPLETED = 'completed';
    case NOT_REQUIRED = 'not_required';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Не сделано',
            self::COMPLETED => 'Сделано',
            self::NOT_REQUIRED => 'Не требуется',
        };
    }
}