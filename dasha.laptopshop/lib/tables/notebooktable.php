<?php

namespace Dasha\Laptopshop\Tables;

use Bitrix\Main\ORM\Data;
use Bitrix\Main\ORM\Fields;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Fields\Relations\ManyToMany;
use Bitrix\Main\ORM\Query\Join;
use Bitrix\Main\SystemException;


class NotebookTable extends Data\DataManager
{
    public static function getTableName(): string
    {
        return 'dasha_laptopshop_notebook';
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
                        new Fields\Validators\UniqueValidator(
                            "При создании производителя образовалось дублирование кода"
                        ),
                    );
                }
            ]),
            new Fields\StringField('NAME', ['required' => true]),
            new Fields\IntegerField('MODEL_ID', ['required' => true]),
            (new Reference(
                'MODEL',
                ModelTable::class,
                Join::on('this.MODEL_ID', 'ref.ID')
            ))->configureJoinType('inner'),
            (new Reference(
                'MANUFACTURER',
                ManufacturerTable::class,
                Join::on('this.MODEL.MANUFACTURER_ID', 'ref.ID')
            ))->configureJoinType('inner'),
            new Fields\IntegerField('YEAR', ['required' => true]),
            new Fields\IntegerField('PRICE', ['required' => true]),
            (new ManyToMany('OPTIONS', OptionTable::class))
                ->configureTableName('dasha_laptopshop_notebook_option')
                ->configureLocalPrimary('ID', 'NOTEBOOK_ID')
                ->configureLocalReference('NOTEBOOK')
                ->configureRemotePrimary('ID', 'OPTION_ID')
                ->configureRemoteReference('OPTION'),
        ];
    }
}
