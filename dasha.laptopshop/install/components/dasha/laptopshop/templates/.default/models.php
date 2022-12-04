<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */


$APPLICATION->IncludeComponent(
    'dasha:laptopshop.list',
    '',
    [
        'CAN_USER_SELECT_AN_ENTITY' => 'N',
        'ENTITY' => 'models',
        'SEF_BASE_URL' => $arParams['SEF_FOLDER'],
        'FILTER' => $arResult['FILTER'],
        'SHOW_LINKS' => 'Y'
    ],
    false
);