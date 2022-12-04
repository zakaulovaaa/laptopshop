<?php

namespace Dasha\Laptopshop\Tables;

use Bitrix\Main\ORM\Data;
use Bitrix\Main\ORM\Fields;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;
use Bitrix\Main\SystemException;

class NotebookOptionTable extends Data\DataManager
{
    public static function getTableName(): string
    {
        return 'dasha_laptopshop_notebook_option';
    }

    /**
     * @throws SystemException
     */
    public static function getMap(): array
    {
        return [
            (new Fields\IntegerField('NOTEBOOK_ID'))
                ->configurePrimary(true),
            (new Reference(
                'NOTEBOOK', NotebookTable::class,
                Join::on('this.NOTEBOOK_ID', 'ref.ID')
            ))
                ->configureJoinType('inner'),
            (new Fields\IntegerField('OPTION_ID'))
                ->configurePrimary(true),
            (new Reference(
                'OPTION', OptionTable::class,
                Join::on('this.OPTION_ID', 'ref.ID')
            ))
                ->configureJoinType('inner'),
        ];
    }
}
