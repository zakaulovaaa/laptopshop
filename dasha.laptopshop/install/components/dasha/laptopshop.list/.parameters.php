<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
/** @var array $arCurrentValues */

/** @global CUserTypeManager $USER_FIELD_MANAGER */

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

if (!Loader::includeModule('dasha.laptopshop')) {
    return;
}


$arComponentParameters = array(
    'PARAMETERS' => array(
        'SEF_BASE_URL' => array(
            'PARENT' => 'BASE',
            'NAME' => GetMessage('SEF_BASE_URL'),
            'TYPE' => 'STRING',
            'DEFAULT' => '',
        ),
        'CAN_USER_SELECT_AN_ENTITY' => array(
            'PARENT' => 'BASE',
            'NAME' => GetMessage('CAN_USER_SELECT_AN_ENTITY'),
            'TYPE' => 'CHECKBOX',
            'DEFAULT' => 'Y',
        ),
        'SHOW_LINKS' => array(
            'PARENT' => 'BASE',
            'NAME' => GetMessage('SHOW_LINKS'),
            'TYPE' => 'CHECKBOX',
            'DEFAULT' => 'N',
        ),
        'ENTITY' => array(
            'PARENT' => 'BASE',
            'NAME' => GetMessage('ENTITY'),
            'TYPE' => 'LIST',
            'VALUES' => [
                'brands' => Loc::getMessage('BRANDS'),
                'models' => Loc::getMessage('MODELS'),
                'notebooks' => Loc::getMessage('NOTEBOOKS'),
            ],
            'DEFAULT' => 'brands',
        ),
    ),
);