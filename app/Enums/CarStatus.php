<?php

namespace App\Enums;

enum CarStatus: string
{
    case SEARCHING = 'searching';
    case PURCHASED = 'purchased';
    case WAITING_DEPARTURE = 'waiting_departure';
    case IN_TRANSIT = 'in_transit';
    case ARRIVED = 'arrived';
    case ON_TRUCK = 'on_truck';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';

    public function label(): string
    {
        return match($this) {
            self::SEARCHING => '🔍 Поиск',
            self::PURCHASED => '💰 Куплено',
            self::WAITING_DEPARTURE => '⏳ Ожидает отправки',
            self::IN_TRANSIT => '🚢 В пути',
            self::ARRIVED => '🇷🇺 Прибыло в РФ',
            self::ON_TRUCK => '🚚 Автовоз',
            self::COMPLETED => '✅ Завершено',
            self::CANCELLED => '❌ Отменено',
        };
    }
}
