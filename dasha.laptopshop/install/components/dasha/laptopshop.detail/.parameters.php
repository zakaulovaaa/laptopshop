<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
/** @var array $arCurrentValues */

/** @global CUserTypeManager $USER_FIELD_MANAGER */

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

try {
    if (!Loader::includeModule('dasha.laptopshop')) {
        return;
    }
} catch (\Bitrix\Main\LoaderException $e) {
}


$arComponentParameters = array(
    'PARAMETERS' => array(
        'SEF_BASE_URL' => array(
            'PARENT' => 'BASE',
            'NAME' => Loc::getMessage('SEF_BASE_URL'),
            'TYPE' => 'STRING',
            'DEFAULT' => '',
        ),
        'ELEMENT_CODE' => array(
            'PARENT' => 'BASE',
            'NAME' => Loc::getMessage('ELEMENT_CODE'),
            'TYPE' => 'STRING',
            'DEFAULT' => '',
        ),
        'ELEMENT_ID' => array(
            'PARENT' => 'BASE',
            'NAME' => Loc::getMessage('ELEMENT_ID'),
            'TYPE' => 'STRING',
            'DEFAULT' => '',
        ),
    ),
);