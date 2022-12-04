<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Loader;
use Bitrix\Main\LoaderException;
use Bitrix\Main\Localization\Loc;

class LaptopShopComponent extends CBitrixComponent
{
    private string $page = 'sections';
    private array $moduleNames = ['dasha.laptopshop'];
    private array $SEF_URL_TEMPLATES = [
        'brands' => 'index.php',
        'models' => '#BRAND_CODE#/',
        'detail' => 'detail/#NOTEBOOK_CODE#/',
        'notebooks' => '#BRAND_CODE#/#MODEL_CODE#/',
    ];

    /**
     * @throws LoaderException
     */
    public function executeComponent()
    {
        $this->loadModules();
        $this->getResult();
        $this->includeComponentTemplate($this->page);
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

    private function getResult()
    {
        $arVariables = [];
        $this->page = CComponentEngine::ParseComponentPath(
            $this->arParams['SEF_FOLDER'],
            $this->SEF_URL_TEMPLATES,
            $arVariables
        );
        if (empty($this->page)) {
            $this->page = 'brands';
        }

        switch ($this->page) {
            case 'models':
                if (!empty($arVariables['BRAND_CODE'])) {
                    $this->arResult['FILTER'] = [
                        'MANUFACTURER_CODE' => $arVariables['BRAND_CODE']
                    ];
                }
                break;
            case 'notebooks':
                if (!empty($arVariables['MODEL_CODE'])) {
                    $this->arResult['FILTER'] = [
                        'MODEL_CODE' => $arVariables['MODEL_CODE']
                    ];
                }
                break;
            case 'detail':
                if (!empty($arVariables['NOTEBOOK_CODE'])) {
                    $this->arResult['FILTER'] = [
                        'CODE' => $arVariables['NOTEBOOK_CODE']
                    ];
                }
                break;
        }
        $this->arResult['VARIABLES'] = $arVariables;
    }

}