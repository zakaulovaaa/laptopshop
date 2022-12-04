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
use Dasha\Laptopshop\Manufacturer;
use Dasha\Laptopshop\Model;
use Dasha\Laptopshop\Notebook;

class LaptopShopListComponent extends CBitrixComponent
{
    private array $moduleNames = ['dasha.laptopshop'];

    /**
     * @throws ArgumentException
     * @throws LoaderException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    public function executeComponent()
    {
        $this->loadModules();
        $this->getResult();
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
    private function getResult()
    {
        $this->arResult['CAN_USER_SELECT_AN_ENTITY'] = $this->arParams['CAN_USER_SELECT_AN_ENTITY'] === 'Y';
        $this->arResult['ENTITIES'] = [
            'brands' => Loc::getMessage('ENTITY_BRANDS'),
            'models' => Loc::getMessage('ENTITY_MODELS'),
            'notebooks' => Loc::getMessage('ENTITY_NOTEBOOKS'),
        ];
        if ($this->arParams['CAN_USER_SELECT_AN_ENTITY'] === 'Y') {
            if (!empty($_GET['type'])) {
                $entity = $_GET['type'];
            } elseif (!empty($this->arParams['ENTITY'])) {
                $entity = $this->arParams['ENTITY'];
            }
        } else {
            if (!empty($this->arParams['ENTITY'])) {
                $entity = $this->arParams['ENTITY'];
            }
        }
        if (empty($entity) || !in_array($entity, array_keys($this->arResult['ENTITIES']))) {
            $entity = 'brands';
        }
        $this->arResult['ENTITY'] = $entity;

        $this->arResult['GRID_ID'] = "laptopshop_$entity";
        $gridOptions = new Bitrix\Main\Grid\Options($this->arResult['GRID_ID']);
        $sort = $gridOptions->GetSorting(['sort' => ['ID' => 'DESC'], 'vars' => ['by' => 'by', 'order' => 'order']]);
        $navParams = $gridOptions->GetNavParams();
        $nav = new Bitrix\Main\UI\PageNavigation("laptopshop_$entity");
        $nav->allowAllRecords(true)
            ->setPageSize($navParams['nPageSize'])
            ->initFromUri();

        switch ($entity) {
            case 'brands':
                $this->arResult['ITEMS'] = Manufacturer::getListForGrid(
                    $nav,
                    $sort,
                    $this->arParams['SEF_BASE_URL'],
                    $this->arParams['SHOW_LINKS'] === 'Y'
                );
                $this->arResult['COLUMNS'] = Manufacturer::getColumnForGrid();
                $this->arResult['NAV'] = $nav;
                break;
            case 'models':
                $this->arResult['ITEMS'] = Model::getListForGrid(
                    $nav,
                    $sort,
                    $this->arParams['SEF_BASE_URL'],
                    $this->arParams['FILTER'],
                    $this->arParams['SHOW_LINKS'] === 'Y'
                );
                $this->arResult['COLUMNS'] = Model::getColumnForGrid();
                $this->arResult['NAV'] = $nav;
                break;
            case 'notebooks':
                $this->arResult['ITEMS'] = Notebook::getListForGrid(
                    $nav,
                    $sort,
                    $this->arParams['SEF_BASE_URL'],
                    $this->arParams['FILTER'],
                    $this->arParams['SHOW_LINKS'] === 'Y'
                );
                $this->arResult['COLUMNS'] = Notebook::getColumnForGrid();
                $this->arResult['NAV'] = $nav;
                break;
        }
    }


}