<?php
/** @global CDatabase $DB */
/** @global CUser $USER */
/** @global CMain $APPLICATION */

use Bitrix\Main\Localization\Loc;

if(!check_bitrix_sessid()) return;

if ($ex = $APPLICATION->GetException())
{
    CAdminMessage::ShowMessage(
        array(
            'TYPE' => 'ERROR',
            'MESSAGE' => Loc::getMessage('MOD_UNINST_ERR'),
            'HTML' => true,
            'DETAILS' => $ex->GetString()
        )
    );
}
else {
    CAdminMessage::ShowNote(Loc::getMessage('MOD_UNINST_OK'));
}
?><form action="<?php echo $APPLICATION->GetCurPage(); ?>">
    <p>
        <input type="hidden" name="lang" value="<?php echo LANGUAGE_ID; ?>">
        <input type="submit" name="" value="<?php echo Loc::getMessage('MOD_BACK'); ?>">
    </p>
    <form>