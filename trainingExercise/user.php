<?php
/**
 * Created by PhpStorm.
 * User: Vernon Oosthuizen
 * Date: 2018/05/04
 * Time: 4:36 PM
 */

require_once 'connect.php';
require_once 'classUser.php';

#INPUT
$iUserId = isset($_SESSION['UserId']) ? (int)$_SESSION['UserId'] : 0;
$sCommand = isset($_POST['command']) ? $_POST['command'] : '';
$sOldPassword = isset($_POST['OldPassword']) ? $_POST['OldPassword'] : '';
$sFirstName = isset($_POST['FirstName']) ? $_POST['FirstName'] : '';
$sLastName = isset($_POST['LastName']) ? $_POST['LastName'] : '';
$sEmailAddress = isset($_POST['EmailAddress']) ? $_POST['EmailAddress'] : '';
$sUsername = isset($_POST['Username']) ? $_POST['Username'] : '';
$sPassword = isset($_POST['Password']) ? $_POST['Password'] : '';

if ($sCommand == 'GetUserDetails' && $iUserId) {
    $oUser = new User();
    $oUser->iUserId = $iUserId;
    $oUser->getUser();
    echo json_encode($oUser);
    die;
}
elseif ($sCommand == 'UpdateUser' && $iUserId) {
    $oUser = new User();
    $oUser->iUserId = $iUserId;
    $oUser->sFirstName = $sFirstName;
    $oUser->sLastName = $sLastName;
    $oUser->sEmailAddress = $sEmailAddress;
    $oUser->sUsername = $sUsername;
    if ($sPassword != '') $oUser->sPassword = md5($sPassword);
    $oUser->updateUser();
    die;
}
elseif ($sCommand == 'CheckOldPassword' && $iUserId) {
    $oUser = new User();
    $oUser->iUserId = $iUserId;
    $oUser->getUser();
    if ($oUser->sPassword === md5($sOldPassword)) echo 'same';
    die;
}