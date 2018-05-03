<?php
/**
 * Created by PhpStorm.
 * User: Vernon Oosthuizen
 * Date: 2018/05/03
 * Time: 3:56 PM
 */

require_once 'connect.php';

$sUsername = isset($_POST['Username']) ? $_POST['Username'] : '';
$sPassword = isset($_POST['Password']) ? $_POST['Password'] : '';

if ($sUsername == '' || $sPassword == '') die('Failed');

$sPassword = md5($sPassword);
$Authenticate = mysqli_query($conn,"select id from User where Username='$sUsername' and Password='$sPassword'");
while ($aUser = mysqli_fetch_assoc($Authenticate))
{
    $_SESSION['UserId'] = $aUser['id'];
    die('success');
}
?>
