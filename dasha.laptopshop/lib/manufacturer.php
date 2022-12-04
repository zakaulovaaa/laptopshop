<?php

namespace Dasha\Laptopshop;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;
use Dasha\Laptopshop\Tables\ManufacturerTable;
use Bitrix\Main\Localization\Loc;
use Exception;

class Manufacturer
{
    public static function getColumnForGrid(): array
    {
        return [
            ['id' => 'ID', 'name' => 'ID', 'sort' => 'ID', 'default' => true],
            ['id' => 'NAME', 'name' => Loc::getMessage('BRAND'), 'sort' => 'NAME', 'default' => true],
        ];
    }

    /**
     * @throws ArgumentException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    public static function getListForGrid(&$nav, $sort, $sefFolder, $showLinks): array
    {
        $urlHelper = new UrlHelper($sefFolder ?? '');
        $manufacturers = [];
        $count = ManufacturerTable::getCount() ?? 0;
        $nav->setRecordCount($count);
        $rsManufacturer = ManufacturerTable::getList([
            'offset' => $nav->getOffset(),
            'limit' => $nav->getLimit(),
            'order' => $sort['sort'],
        ]);
        while ($manufacturer = $rsManufacturer->fetch()) {
            if ($showLinks) {
                $url = $urlHelper->getUrlBrand($manufacturer['CODE']);
                if ($url) {
                    $manufacturer['NAME'] = "<a href=\"$url\">{$manufacturer['NAME']}</a>";
                }
            }
            $manufacturers[] = [
                'data' => [
                    'ID' => $manufacturer['ID'],
                    'NAME' => $manufacturer['NAME'],
                ]
            ];
        }
        return $manufacturers;
    }

    /**
     * @throws Exception
     */
    public static function fillWithTestData()
    {
        $data = file_get_contents(
            $_SERVER['DOCUMENT_ROOT'] . '/local/modules/dasha.laptopshop/install/testdata/manufacturer.json'
        );
        $manufacturers = json_decode($data, true);

        foreach ($manufacturers as $manufacturer) {
            ManufacturerTable::add($manufacturer);
        }
    }
}