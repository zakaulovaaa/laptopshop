<?php

namespace Dasha\Laptopshop\Tables;

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ORM\Data;
use Bitrix\Main\ORM\Fields;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Fields\Relations\OneToMany;
use Bitrix\Main\ORM\Query\Join;
use Bitrix\Main\SystemException;

class ModelTable extends Data\DataManager
{
    public static function getTableName(): string
    {
        return 'dasha_laptopshop_model';
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
            new Fields\IntegerField('MANUFACTURER_ID', ['required' => true]),
            (new Reference(
                'MANUFACTURER',
                ManufacturerTable::class,
                Join::on('this.MANUFACTURER_ID', 'ref.ID')
            ))->configureJoinType('inner'),
            (new OneToMany('NOTEBOOKS', NotebookTable::class, 'MODEL'))->configureJoinType('inner')
        ];
    }
}
