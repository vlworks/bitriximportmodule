<?php

use Bitrix\Main\Application;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;

class vlworks_bitriximportmodule extends CModule {
    var array $requiredModules;

    public function __construct()
    {
        $arModuleVersion = array();
        include(__DIR__.'/version.php');
        if (!empty($arModuleVersion['VERSION']))
        {
            $this->MODULE_VERSION = $arModuleVersion["VERSION"];
            $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        }

        $this->MODULE_ID = "vlworks.bitriximportmodule";
        $this->MODULE_NAME = Loc::getMessage("VLWORKS_BITRIXIMPORTMODULE_MODULE_NAME");
        $this->MODULE_DESCRIPTION = Loc::getMessage("VLWORKS_BITRIXIMPORTMODULE_MODULE_DESCRIPTION");

        $this->PARTNER_NAME = Loc::getMessage("VLWORKS_BITRIXIMPORTMODULE_PARTNER_NAME");
        $this->PARTNER_URI = Loc::getMessage("VLWORKS_BITRIXIMPORTMODULE_PARTNER_URI");

        $this->requiredModules = ['catalog'];
    }

    function DoInstall(): void
    {
        global $APPLICATION;

        if ($this->isVersionD7() && $this->isRequiredModulesInstalled())
        {
            $this->InstallDB();
            $this->InstallEvents();
            $this->InstallFiles();

            ModuleManager::registerModule($this->MODULE_ID);
        }
        else
        {
            $APPLICATION->ThrowException(Loc::getMessage("VLWORKS_BITRIXIMPORTMODULE_INSTALL_ERROR_VERSION", ['#MODULES#' => ": ".implode(',', $this->requiredModules)]));
        }

        $APPLICATION->IncludeAdminFile(
            $this->MODULE_NAME,
            $this->GetPath()."/install/step.php"
        );
    }

    function DoUninstall(): void
    {
        global $APPLICATION;

        ModuleManager::unRegisterModule($this->MODULE_ID);

        $this->UnInstallFiles();
        $this->UnInstallEvents();

        $APPLICATION->IncludeAdminFile(
            $this->MODULE_NAME,
            $this->GetPath()."/install/unstep.php"
        );
    }

    function InstallFiles(): bool
    {
        CopyDirFiles($this->GetPath().'/install/catalog_import', $_SERVER['DOCUMENT_ROOT'].'/bitrix/php_interface/include/catalog_import');

        return true;
    }

    function UnInstallFiles(): bool
    {
        DeleteDirFiles($this->GetPath().'/install/catalog_import', $_SERVER['DOCUMENT_ROOT'].'/bitrix/php_interface/include/catalog_import');

        return true;
    }


    function isVersionD7(): bool
    {
        return CheckVersion(ModuleManager::getVersion('main'), '14.00.00');
    }

    function isRequiredModulesInstalled(): bool
    {
        foreach ($this->requiredModules as $module)
        {
            if (!ModuleManager::isModuleInstalled($module))
                return false;
        }

        return true;
    }

    public function GetPath($notDocumentRoot = false): string
    {
        if ($notDocumentRoot)
            return str_replace(Application::getDocumentRoot(), '', dirname(__DIR__));
        else
            return dirname(__DIR__);
    }
}