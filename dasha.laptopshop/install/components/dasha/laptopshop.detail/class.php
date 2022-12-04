<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\ArgumentException;
use Bitrix\Main\Loader;
use Bitrix\Main\LoaderException;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;
use Dasha\Laptopshop\UrlHelper;
use Dasha\Laptopshop\Tables\NotebookTable;

class LaptopShopDetailComponent extends CBitrixComponent
{
    private string $page = 'sections';
    private array $moduleNames = ['dasha.laptopshop'];

    /**
     * @throws LoaderException
     */
    public function executeComponent()
    {
        $this->loadModules();
        try {
            $this->getResult();
        } catch (ObjectPropertyException|ArgumentException|SystemException $e) {
            ShowError($e->getMessage());
        }
        $this->includeComponentTemplate();
    }

    /**
     * @throws LoaderException
     */
    private function loadModules(): void
    {
        foreach ($this->moduleNames as $moduleName) {
            $moduleLoaded = Loader::includeModule($moduleName);
            if (!$moduleLoaded) {
                throw new LoaderException(
                    Loc::getMessage('MODULE_LOAD_ERROR', ['#MODULE_NAME#' => $moduleName])
                );
            }
        }
    }

    /**
     * @throws ObjectPropertyException
     * @throws SystemException
     * @throws ArgumentException
     */
    private function getResult(): void
    {
        $filter = [];
        if (!empty($this->arParams['ELEMENT_ID'])) {
            $filter['ID'] = $this->arParams['ELEMENT_ID'];
        } elseif (!empty($this->arParams['ELEMENT_CODE'])) {
            $filter['CODE'] = $this->arParams['ELEMENT_CODE'];
        }

        if (!empty($filter)) {
            $rsNotebook = NotebookTable::getList(
                [
                    'filter' => $filter,
                    'select' => [
                        '*',
                        'OPTIONS',
                        'MODEL',
                        'MANUFACTURER',
                        'MODEL_NAME' => 'DASHA_LAPTOPSHOP_TABLES_NOTEBOOK_MODEL_NAME',
                        'MODEL_CODE' => 'DASHA_LAPTOPSHOP_TABLES_NOTEBOOK_MODEL_CODE',
                        'MANUFACTURER_NAME' => 'DASHA_LAPTOPSHOP_TABLES_NOTEBOOK_MANUFACTURER_NAME',
                        'MANUFACTURER_CODE' => 'DASHA_LAPTOPSHOP_TABLES_NOTEBOOK_MANUFACTURER_CODE',
                        'OPTIONS_NAME' => 'DASHA_LAPTOPSHOP_TABLES_NOTEBOOK_OPTIONS_NAME',
                    ]
                ]
            );
            $notebookInfo = [];
            $urlHelper = new UrlHelper($this->arParams['SEF_BASE_URL'] ?? '');
            while ($notebook = $rsNotebook->fetch()) {
                $notebookInfo['NAME'] = $notebook['NAME'];
                $notebookInfo['MODEL'] = [
                    'NAME' => $notebook['MODEL_NAME'],
                    'URL' => $urlHelper->getUrlModel($notebook['MODEL_CODE'], $notebook['MANUFACTURER_CODE']),
                ];
                $notebookInfo['MANUFACTURER'] = [
                    'NAME' => $notebook['MANUFACTURER_NAME'],
                    'URL' => $urlHelper->getUrlBrand($notebook['MANUFACTURER_CODE']),
                ];
                $notebookInfo['PRICE'] = number_format($notebook['PRICE'], 0, '.', ' ') . ' руб.';
                $notebookInfo['YEAR'] = $notebook['YEAR'];
                $notebookInfo['OPTIONS'][] = [
                    'NAME' => $notebook['OPTIONS_NAME']
                ];
            }

            $this->arResult['NOTEBOOK'] = $notebookInfo;
        }
    }

}