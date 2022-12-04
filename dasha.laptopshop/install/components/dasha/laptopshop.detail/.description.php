<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;

$arComponentDescription = array(
    'NAME' => GetMessage('LAPTOPSHOP_DETAIL_NAME'),
    'DESCRIPTION' => Loc::getMessage('LAPTOPSHOP_DETAIL_DESCRIPTION'),
    'SORT' => 20,
    'PATH' => array(
        'ID' => 'dasha',
        'NAME' => Loc::getMessage('MODULE_BY_DASHA'),
        'SORT' => 30,
    )
);
?>