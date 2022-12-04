<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;

$arComponentDescription = array(
    'NAME' => Loc::getMessage('LAPTOPSHOP_NAME'),
    'DESCRIPTION' => Loc::getMessage('LAPTOPSHOP_DESCRIPTION'),
    'COMPLEX' => 'Y',
    'SORT' => 10,
    'PATH' => array(
        'ID' => 'dasha',
        'NAME' => Loc::getMessage('MODULE_BY_DASHA'),
        'SORT' => 30,
    )
);