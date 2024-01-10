<?php
/** @global CDatabase $DB */
/** @global CUser $USER */

/** @global CMain $APPLICATION */

use Bitrix\Main\Localization\Loc;

if (!check_bitrix_sessid()) return;

if ($ex = $APPLICATION->GetException()) {
    CAdminMessage::ShowMessage(
        array(
            'TYPE' => 'ERROR',
            'MESSAGE' => Loc::getMessage('MOD_INST_ERR'),
            'DETAILS' => $ex->GetString(),
            'HTML' => true
        )
    );
} else {
    CAdminMessage::ShowNote(Loc::getMessage('MOD_INST_OK'));
} ?>
<form action="<?php echo $APPLICATION->GetCurPage(); ?>">
    <p>
        <input type="hidden" name="lang" value="<?php echo LANGUAGE_ID; ?>">
        <input id="redirect-btn" type="button" name="redirect" value="<?php echo Loc::getMessage("VLWORKS_BITRIXIMPORTMODULE_STEP_IMPORT_LISTING"); ?>">
        <input type="submit" name="" value="<?php echo Loc::getMessage('MOD_BACK'); ?>">
    </p>
<form>
    <script>
        if (window['redirect-btn']) window['redirect-btn'].onclick = () => { window.location.href = '/bitrix/admin/cat_import_setup.php' }
    </script>