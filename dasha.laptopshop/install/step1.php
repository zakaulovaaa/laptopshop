<?php
IncludeModuleLangFile($_SERVER["DOCUMENT_ROOT"] . "/local/modules/dasha.laptopshop/install/index.php");
use Bitrix\Main\Localization\Loc;
global $APPLICATION;
?>

<form action="<?= $APPLICATION->GetCurPage() ?>" name="form1">
    <?= bitrix_sessid_post() ?>
    <input type="hidden" name="lang" value="<?= LANGUAGE_ID ?>">
    <input type="hidden" name="id" value="dasha.laptopshop">
    <input type="hidden" name="install" value="Y">
    <input type="hidden" name="step" value="2">
    <input type="checkbox" id="recreate_table" name="recreate_table" value="Y" checked>
    <label for="recreate_table"><?= Loc::getMessage('DASHA_LAPTOPSHOP_RECREATE_TABLE') ?></label>
    <br><br>
    <input type="submit" name="inst" value="<?= Loc::getMessage("MOD_INSTALL") ?>">
</form>