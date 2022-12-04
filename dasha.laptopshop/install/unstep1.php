<?php
IncludeModuleLangFile($_SERVER["DOCUMENT_ROOT"] . "/local/modules/dasha.laptopshop/install/index.php");
use Bitrix\Main\Localization\Loc;
global $APPLICATION;
?>

<form action="<?= $APPLICATION->GetCurPage() ?>" name="form1">
    <?= bitrix_sessid_post() ?>
    <input type="hidden" name="lang" value="<?= LANGUAGE_ID ?>">
    <input type="hidden" name="id" value="dasha.laptopshop">
    <input type="hidden" name="uninstall" value="Y">
    <input type="hidden" name="step" value="2">
    <input type="checkbox" name="delete_table" id="delete_table" value="Y">
    <label for="delete_table"><?= Loc::getMessage('DASHA_LAPTOPSHOP_DELETE_TABLE') ?></label>
    <br><br>
    <input type="submit" name="inst" value="<?= Loc::getMessage("MOD_UNINST_DEL") ?>">
</form>