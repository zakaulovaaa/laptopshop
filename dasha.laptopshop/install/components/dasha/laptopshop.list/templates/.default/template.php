<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

/** @var array $arParams */
/** @var array $arResult */

/** @global CMain $APPLICATION */

use Bitrix\Main\Localization\Loc;

$this->addExternalCss('/bitrix/css/main/bootstrap.css');
?>

<div class="container">
    <?php
    if ($arResult['ENTITY'] !== 'brands'): ?>
        <a href="<?= $arParams['SEF_BASE_URL'] ?>"><?= Loc::getMessage('TO_MAIN_PAGE') ?></a>
    <?php
    endif; ?>


    <?php
    if ($arResult['CAN_USER_SELECT_AN_ENTITY']): ?>
        <br><br>
        <header class="d-flex justify-content-center py-3">
            <ul class="nav nav-pills">
                <?php
                foreach ($arResult['ENTITIES'] as $code => $name): ?>
                    <li class="nav-item <?php
                    if ($arResult['ENTITY'] === $code): ?>active <?php
                    endif; ?>">
                        <a href="?type=<?= $code ?>" class="nav-link" aria-current="page"><?= $name ?></a>
                    </li>
                <?php
                endforeach; ?>
            </ul>
        </header>
    <?php
    endif; ?>
    <?php
    $APPLICATION->IncludeComponent(
        'bitrix:main.ui.grid',
        '',
        [
            'TOTAL_ROWS_COUNT' => $arResult['NAV']->getRecordCount() ?? 0,
            'GRID_ID' => $arResult['GRID_ID'],
            'COLUMNS' => $arResult['COLUMNS'],
            'ROWS' => $arResult['ITEMS'],
            'SHOW_ROW_CHECKBOXES' => false,
            'NAV_OBJECT' => $arResult['NAV'],
            'AJAX_MODE' => 'Y',
            'AJAX_ID' => \CAjax::getComponentID('bitrix:main.ui.grid', '.default', ''),
            'PAGE_SIZES' => [
                ['NAME' => "5", 'VALUE' => '5'],
                ['NAME' => '10', 'VALUE' => '10'],
                ['NAME' => '20', 'VALUE' => '20'],
                ['NAME' => '50', 'VALUE' => '50'],
                ['NAME' => '100', 'VALUE' => '100']
            ],
            'AJAX_OPTION_JUMP' => 'N',
            'SHOW_CHECK_ALL_CHECKBOXES' => true,
            'SHOW_ROW_ACTIONS_MENU' => true,
            'SHOW_GRID_SETTINGS_MENU' => true,
            'SHOW_NAVIGATION_PANEL' => true,
            'SHOW_PAGINATION' => true,
            'SHOW_SELECTED_COUNTER' => false,
            'SHOW_TOTAL_COUNTER' => true,
            'SHOW_PAGESIZE' => true,
            'SHOW_ACTION_PANEL' => false,
            'ALLOW_COLUMNS_SORT' => true,
            'ALLOW_COLUMNS_RESIZE' => true,
            'ALLOW_HORIZONTAL_SCROLL' => true,
            'ALLOW_SORT' => true,
            'ALLOW_PIN_HEADER' => true,
            'AJAX_OPTION_HISTORY' => 'N'
        ]
    ); ?>
</div>
