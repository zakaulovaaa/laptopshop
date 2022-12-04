<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */


$APPLICATION->IncludeComponent(
    'dasha:laptopshop.detail',
    '',
    [
        'SEF_BASE_URL' => $arParams['SEF_FOLDER'],
        'ELEMENT_CODE' => $arResult['FILTER']['CODE'],
        'ELEMENT_ID' => $arResult['FILTER']['ID']
    ],
    false
);