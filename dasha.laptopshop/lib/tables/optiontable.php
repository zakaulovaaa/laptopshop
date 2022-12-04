<?php

namespace Dasha\Laptopshop\Tables;

use Bitrix\Main\ORM\Data;
use Bitrix\Main\ORM\Fields;
use Bitrix\Main\SystemException;


class OptionTable extends Data\DataManager
{
    public static function getTableName(): string
    {
        return 'dasha_laptopshop_option';
    }

    /**
     * @throws SystemException
     */
    public static function getMap(): array
    {
        return [
            new Fields\IntegerField('ID', ['primary' => true, 'autocomplete' => true]),
            new Fields\StringField('NAME', ['required' => true]),
        ];
    }
}
