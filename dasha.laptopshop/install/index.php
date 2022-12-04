<?php

use Bitrix\Main\ArgumentException;
use Bitrix\Main\DB\SqlQueryException;
use Bitrix\Main\LoaderException;
use Bitrix\Main\SystemException;
use Bitrix\Main\Localization\Loc;
use Dasha\Laptopshop\Tables\ManufacturerTable;
use Dasha\Laptopshop\Tables\ModelTable;
use Dasha\Laptopshop\Tables\NotebookTable;
use Dasha\Laptopshop\Tables\OptionTable;
use Dasha\Laptopshop\Tables\NotebookOptionTable;
use Dasha\Laptopshop\Manufacturer;
use Dasha\Laptopshop\Model;
use Dasha\Laptopshop\Notebook;
use Dasha\Laptopshop\Option;
use Bitrix\Main\Loader;
use Bitrix\Main\Application;

class dasha_laptopshop extends CModule
{
    public $MODULE_ID = 'dasha.laptopshop';
    public $MODULE_NAME = 'Магазин ноутбуков';
    public $MODULE_DESCRIPTION = 'Модуль решает проблемы хранения и поиска ноутбуков на сайте интернет-магазина';
    public $PARTNER_NAME = 'Dasha';
    public $PARTNER_URI = 'http://zakaulovaaa.ru/';

    public function __construct()
    {
        $arModuleVersion = [];
        include __DIR__ . '/version.php';
        if (isset($arModuleVersion['VERSION'], $arModuleVersion['VERSION_DATE'])) {
            $this->MODULE_VERSION = $arModuleVersion['VERSION'];
            $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        }
    }

    /**
     * @throws LoaderException
     * @throws ArgumentException
     * @throws SqlQueryException
     * @throws SystemException
     */
    public function DoInstall(): void
    {
        global $APPLICATION, $step;
        $step = IntVal($step);
        if ($step < 2) {
            $APPLICATION->IncludeAdminFile(
                Loc::getMessage('DASHA_LAPTOPSHOP_INSTALL_TITLE'),
                $_SERVER['DOCUMENT_ROOT'] . '/local/modules/dasha.laptopshop/install/step1.php'
            );
        } elseif ($step == 2) {
            RegisterModule('dasha.laptopshop');
            if ($_REQUEST['recreate_table'] === 'Y') {
                $this->InstallDB();
            }
            $this->InstallFiles();
        }
    }

    /**
     * @throws LoaderException
     * @throws ArgumentException
     * @throws SqlQueryException
     * @throws SystemException
     * @throws Exception
     */
    public function InstallDB(): bool
    {
        if (Loader::includeModule($this->MODULE_ID)) {
            $this->UnInstallDB();
            ManufacturerTable::getEntity()->createDbTable();
            ModelTable::getEntity()->createDbTable();
            OptionTable::getEntity()->createDbTable();
            NotebookTable::getEntity()->createDbTable();
            NotebookOptionTable::getEntity()->createDbTable();

            Manufacturer::fillWithTestData();
            Model::fillWithTestData();
            Notebook::fillWithTestData();
            Option::fillWithTestData();
        }
        return true;
    }

    public function InstallFiles()
    {
        CopyDirFiles(
            $_SERVER['DOCUMENT_ROOT'] . '/local/modules/dasha.laptopshop/install/components',
            $_SERVER['DOCUMENT_ROOT'] . '/local/components',
            true,
            true
        );
    }

    /**
     * @throws SqlQueryException
     * @throws LoaderException
     */
    public function DoUninstall(): void
    {
        if (Loader::includeModule($this->MODULE_ID)) {
            global $APPLICATION, $step;
            $step = IntVal($step);

            if ($step < 2) {
                $APPLICATION->IncludeAdminFile(
                    GetMessage('DASHA_LAPTOPSHOP_INSTALL_TITLE'),
                    $_SERVER['DOCUMENT_ROOT'] . '/local/modules/dasha.laptopshop/install/unstep1.php'
                );
            } elseif ($step == 2) {
                if ($_REQUEST['delete_table'] === 'Y') {
                    $this->UnInstallDB();
                }
                $this->UnInstallFiles();
                UnRegisterModule('dasha.laptopshop');
            }
        }
    }


    /**
     * @throws SqlQueryException
     */
    public function UnInstallDB($arParams = []): bool
    {
        $connection = Application::getConnection();
        if ($connection->isTableExists(ManufacturerTable::getTableName())) {
            $connection->dropTable(ManufacturerTable::getTableName());
        }
        if ($connection->isTableExists(ModelTable::getTableName())) {
            $connection->dropTable(ModelTable::getTableName());
        }
        if ($connection->isTableExists(NotebookTable::getTableName())) {
            $connection->dropTable(NotebookTable::getTableName());
        }
        if ($connection->isTableExists(OptionTable::getTableName())) {
            $connection->dropTable(OptionTable::getTableName());
        }
        if ($connection->isTableExists(NotebookOptionTable::getTableName())) {
            $connection->dropTable(NotebookOptionTable::getTableName());
        }
        return true;
    }

    public function UnInstallFiles()
    {
        /* из тз: При удалении.. Компоненты и прочую файловую составляющую не трогаем. */
        //DeleteDirFilesEx('/local/components/dasha/');
    }

}