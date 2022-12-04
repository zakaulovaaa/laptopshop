<?php

namespace Dasha\Laptopshop;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;
use Dasha\Laptopshop\Tables\NotebookTable;
use Bitrix\Main\Localization\Loc;
use Exception;

class Notebook
{
    public static function getColumnForGrid(): array
    {
        return [
            ['id' => 'ID', 'name' => 'ID', 'sort' => 'ID', 'default' => true],
            ['id' => 'MANUFACTURER', 'name' => Loc::getMessage('BRAND'), 'default' => true],
            ['id' => 'MODEL', 'name' => Loc::getMessage('MODEL'), 'default' => true],
            ['id' => 'NAME', 'name' => Loc::getMessage('NOTEBOOK'), 'sort' => 'NAME', 'default' => true],
            ['id' => 'YEAR', 'name' => Loc::getMessage('YEAR'), 'sort' => 'YEAR', 'default' => true],
            ['id' => 'PRICE', 'name' => Loc::getMessage('PRICE'), 'sort' => 'PRICE', 'default' => true],
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
        $nav->setRecordCount(self::getCount($filter));
        $notebooks = [];
        $rsNotebooks = NotebookTable::getList([
            'filter' => $filter ?? [],
            'offset' => $nav->getOffset(),
            'limit' => $nav->getLimit(),
            'order' => $sort['sort'],
            'select' => [
                '*',
                'MODEL',
                'MODEL_NAME' => 'DASHA_LAPTOPSHOP_TABLES_NOTEBOOK_MODEL_NAME',
                'MODEL_CODE' => 'DASHA_LAPTOPSHOP_TABLES_NOTEBOOK_MODEL_CODE',
                'MANUFACTURER',
                'MANUFACTURER_CODE' => 'DASHA_LAPTOPSHOP_TABLES_NOTEBOOK_MANUFACTURER_CODE',
                'MANUFACTURER_NAME' => 'DASHA_LAPTOPSHOP_TABLES_NOTEBOOK_MANUFACTURER_NAME'
            ],
        ]);
        while ($notebook = $rsNotebooks->fetch()) {
            if ($showLinks) {
                $url = $urlHelper->getUrlNotebook($notebook['CODE']);
                if ($url) {
                    $notebook['NAME'] = "<a href=\"$url\">{$notebook['NAME']}</a>";
                }

                $urlModel = $urlHelper->getUrlModel($notebook['MODEL_CODE'], $notebook['MANUFACTURER_CODE']);
                if ($url) {
                    $notebook['MODEL_NAME'] = "<a href=\"$urlModel\">{$notebook['MODEL_NAME']}</a>";
                }
                $urlBrand = $urlHelper->getUrlBrand($notebook['MANUFACTURER_CODE']);
                if ($url) {
                    $notebook['MANUFACTURER_NAME'] = "<a href=\"$urlBrand\">{$notebook['MANUFACTURER_NAME']}</a>";
                }
            }
            $notebooks[] = [
                'data' => [
                    'ID' => $notebook['ID'],
                    'NAME' => $notebook['NAME'],
                    'MANUFACTURER' => $notebook['MANUFACTURER_NAME'],
                    'MODEL' => $notebook['MODEL_NAME'],
                    'YEAR' => $notebook['YEAR'],
                    'PRICE' => $notebook['PRICE'],
                ]
            ];
        }
        return $notebooks;
    }

    /**
     * @throws ObjectPropertyException
     * @throws SystemException
     * @throws ArgumentException
     */
    private static function getCount($filter): int
    {
        $rsNotebooks = NotebookTable::getList([
            'filter' => $filter ?? [],
            'select' => [
                '*',
                'MODEL',
                'MODEL_CODE' => 'DASHA_LAPTOPSHOP_TABLES_NOTEBOOK_MODEL_CODE',
            ],
        ]);
        return $rsNotebooks->getSelectedRowsCount();
    }


    /**
     * @throws Exception
     */
    public static function fillWithTestData()
    {
        $data = file_get_contents(
            $_SERVER['DOCUMENT_ROOT'] . '/local/modules/dasha.laptopshop/install/testdata/notebook.json'
        );
        $notebooks = json_decode($data, true);

        foreach ($notebooks as $notebook) {
            NotebookTable::add($notebook);
        }
    }
}