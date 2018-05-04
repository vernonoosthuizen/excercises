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
$iUserId = isset($_SESSION['UserId']) ? $_SESSION['UserId'] : 0;
$sCommand = isset($_POST['command']) ? $_POST['command'] : '';

if ($sCommand == 'GetUserDetails')
{
    $aUser = [];
    $oUser = new User();
    $oUser->iUserId = $iUserId;
    $oUser->getUser();
    echo json_encode($oUser);
    die;
}