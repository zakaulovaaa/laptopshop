<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
/** @var array $arCurrentValues */

/** @global CUserTypeManager $USER_FIELD_MANAGER */

use Bitrix\Main\Loader;
use Bitrix\Main\LoaderException;

try {
    if (!Loader::includeModule('dasha.laptopshop')) {
        return;
    }
} catch (LoaderException $e) {
}

$arComponentParameters = array(
    'PARAMETERS' => array(
        'SEF_MODE' => array(),
    ),
);