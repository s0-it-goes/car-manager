<?php

namespace App\Enums;

enum CarTaskType: string
{
    case SEARCH_CAR = 'search_car';
    case INVOICE = 'invoice';
    case PASSPORT_COPY = 'passport_copy';
    case SNILS = 'snils';
    case INN = 'inn';
    case CONTRACT = 'contract';
    case IMPORT_EXPLANATION = 'import_explanation';

    public function label(): string
    {
        return match ($this) {
            self::SEARCH_CAR => 'Поиск авто',
            self::INVOICE => 'Выставлен инвойс',
            self::PASSPORT_COPY => 'Заверенная копия паспорта',
            self::SNILS => 'СНИЛС',
            self::INN => 'ИНН',
            self::CONTRACT => 'Договор',
            self::IMPORT_EXPLANATION => 'Объяснение на ввоз машины до 3-х лет',
        };
    }
}