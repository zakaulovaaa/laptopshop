<?php

namespace Dasha\Laptopshop\Tables;

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ORM\Data;
use Bitrix\Main\ORM\Fields;
use Bitrix\Main\ORM\Fields\Relations\OneToMany;
use Bitrix\Main\SystemException;

class ManufacturerTable extends Data\DataManager
{
    public static function getTableName(): string
    {
        return 'dasha_laptopshop_manufacturer';
    }

    /**
     * @throws SystemException
     */
    public static function getMap(): array
    {
        return [
            new Fields\IntegerField('ID', ['primary' => true, 'autocomplete' => true, 'required' => true]),
            new Fields\StringField('CODE', [
                'required' => true,
                'validation' => function () {
                    return array(
                        new Fields\Validators\UniqueValidator(Loc::getMessage('CODE_DUPLICATION')),
                    );
                }
            ]),
            new Fields\StringField('NAME', ['required' => true]),
            (new OneToMany('MODELS', ModelTable::class, 'MANUFACTURER'))->configureJoinType('inner')
        ];
    }
}
