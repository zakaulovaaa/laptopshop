<?php

namespace Dasha\Laptopshop;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;
use Dasha\Laptopshop\Tables\ModelTable;
use Bitrix\Main\Localization\Loc;
use Exception;

class Model
{
    public static function getColumnForGrid(): array
    {
        return [
            ['id' => 'ID', 'name' => 'ID', 'sort' => 'ID', 'default' => true],
            ['id' => 'MANUFACTURER', 'name' => Loc::getMessage('BRAND'), 'default' => true],
            ['id' => 'NAME', 'name' => Loc::getMessage('MODEL'), 'sort' => 'NAME', 'default' => true],
        ];
    }

    /**
     * @throws ObjectPropertyException
     * @throws SystemException
     * @throws ArgumentException
     */
    public static function getListForGrid(&$nav, $sort, $sefFolder, $filter, $showLinks): array
    {
        $urlHelper = new UrlHelper($sefFolder ?? '');
        $models = [];
        $nav->setRecordCount(self::getCount($filter));
        $rsModels = ModelTable::getList([
            'filter' => $filter ?? [],
            'offset' => $nav->getOffset(),
            'limit' => $nav->getLimit(),
            'order' => $sort['sort'],
            'select' => [
                '*',
                'MANUFACTURER',
                'MANUFACTURER_NAME' => 'DASHA_LAPTOPSHOP_TABLES_MODEL_MANUFACTURER_NAME',
                'MANUFACTURER_CODE' => 'DASHA_LAPTOPSHOP_TABLES_MODEL_MANUFACTURER_CODE',
            ],
        ]);
        while ($model = $rsModels->fetch()) {
            if ($showLinks) {
                $urlModel = $urlHelper->getUrlModel($model['CODE'], $model['MANUFACTURER_CODE']);
                if ($urlModel) {
                    $model['NAME'] = "<a href=\"$urlModel\">{$model['NAME']}</a>";
                }
                $urlBrand = $urlHelper->getUrlBrand($model['MANUFACTURER_CODE']);
                if ($urlBrand) {
                    $model['MANUFACTURER_NAME'] = "<a href=\"$urlBrand\">{$model['MANUFACTURER_NAME']}</a>";
                }
            }
            $models[] = [
                'data' => [
                    'ID' => $model['ID'],
                    'NAME' => $model['NAME'],
                    'MANUFACTURER' => $model['MANUFACTURER_NAME'],
                ]
            ];
        }
        return $models;
    }

    private static function getCount($filter): int
    {
        $rsNotebooks = ModelTable::getList([
            'select' => [
                '*',
                'MANUFACTURER',
                'MANUFACTURER_CODE' => 'DASHA_LAPTOPSHOP_TABLES_MODEL_MANUFACTURER_CODE',
            ],
            'filter' => $filter ?? [],
        ]);
        return $rsNotebooks->getSelectedRowsCount();
    }

    /**
     * @throws Exception
     */
    public static function fillWithTestData()
    {
        $data = file_get_contents(
            $_SERVER['DOCUMENT_ROOT'] . '/local/modules/dasha.laptopshop/install/testdata/model.json'
        );
        $models = json_decode($data, true);

        foreach ($models as $model) {
            ModelTable::add($model);
        }
    }
}