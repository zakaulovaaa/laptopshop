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
    <a href="<?= $arParams['SEF_BASE_URL'] ?>"><?= Loc::getMessage('TO_MAIN_PAGE') ?></a>
    <br>
    <br>
    <?php
    if (!empty($arResult['NOTEBOOK'])): ?>
        <h1><?= $arResult['NOTEBOOK']['NAME'] ?></h1>

        <br><br>
        <h4><?= Loc::getMessage('BRAND') ?>: </h4>
        <br>
        <div class="list-group w-auto">
            <a href="<?= $arResult['NOTEBOOK']['MANUFACTURER']['URL'] ?>"
               class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                <div class="d-flex gap-2 w-100 justify-content-between">
                    <div>
                        <h6 class="mb-0"><?= $arResult['NOTEBOOK']['MANUFACTURER']['NAME'] ?></h6>
                    </div>
                </div>
            </a>
        </div>
        <br>
        <h4><?= Loc::getMessage('MODEL') ?>: </h4><br>
        <div class="list-group w-auto">
            <a href="<?= $arResult['NOTEBOOK']['MODEL']['URL'] ?>"
               class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                <div class="d-flex gap-2 w-100 justify-content-between">
                    <div>
                        <h6 class="mb-0"><?= $arResult['NOTEBOOK']['MODEL']['NAME'] ?></h6>
                    </div>
                </div>
            </a>
        </div>
        <br>
        <h4><?= Loc::getMessage('PRICE') ?>: </h4><br>
        <div class="list-group w-auto">
            <div class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                <div class="d-flex gap-2 w-100 justify-content-between">
                    <div>
                        <h6 class="mb-0"><?= $arResult['NOTEBOOK']['PRICE'] ?></h6>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <h4><?= Loc::getMessage('YEAR') ?>: </h4><br>
        <div class="list-group w-auto">
            <div class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                <div class="d-flex gap-2 w-100 justify-content-between">
                    <div>
                        <h6 class="mb-0"><?= $arResult['NOTEBOOK']['YEAR'] ?></h6>
                    </div>
                </div>
            </div>
        </div>
        <br>


        <?php
        if (!empty($arResult['NOTEBOOK']['OPTIONS'])): ?>
            <h4><?= Loc::getMessage('OPTIONS') ?>: </h4>
            <br>
            <div class="list-group w-auto">
                <?php
                foreach ($arResult['NOTEBOOK']['OPTIONS'] as $option): ?>
                    <div class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                        <div class="d-flex gap-2 w-100 justify-content-between">
                            <div>
                                <h6 class="mb-0"><?= $option['NAME'] ?></h6>
                            </div>
                        </div>
                    </div>
                <?php
                endforeach; ?>
            </div>
        <?php
        endif; ?>
    <?php
    else: ?>
        <?= Loc::getMessage('ELEMENT_NOT_FOUND') ?>
    <?php
    endif; ?>
</div>
