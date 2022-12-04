<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$arComponentDescription = array(
    'NAME' => GetMessage('LAPTOPSHOP_LIST_NAME'),
    'DESCRIPTION' => GetMessage('LAPTOPSHOP_LIST_DESCRIPTION'),
    'SORT' => 10,
    'PATH' => array(
        'ID' => 'dasha',
        'NAME' => GetMessage('MODULE_BY_DASHA'),
        'SORT' => 30,
    )
);
?>