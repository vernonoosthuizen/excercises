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

$sIPAddress = $_SERVER['REMOTE_ADDR'];
$sAttemptTime = date('Y-m-d H:i:s');

$sTimeTenMinutesAgo = date('Y-m-d H:i:s', time() - 60*10);
//remove all previous attempts longer than 10 minutes ago
mysqli_query($conn, "delete from LoginAttempt where AttemptTime < '$sTimeTenMinutesAgo'");

//select all attempts for the last 10min from this IP and block if more than 5
$rCount = mysqli_query($conn, "select id from LoginAttempt where AttemptTime > '$sTimeTenMinutesAgo' and IPAddress='$sIPAddress'");
if (mysqli_num_rows($rCount) > 4) die('Login attempts');

if ($sUsername == '' || $sPassword == '')
{

//log all attempts
    mysqli_query($conn,"insert into LoginAttempt (IPAddress, AttemptTime, Username) values ('$sIPAddress', '$sAttemptTime', '$sUsername')");

    header('Location: login.html');
    die('Failed');
}

$sPassword = md5($sPassword);
$Authenticate = mysqli_query($conn,"select id from User where Username='$sUsername' and Password='$sPassword'");
while ($aUser = mysqli_fetch_assoc($Authenticate))
{
    $_SESSION['UserId'] = $aUser['id'];
    die('success');
}

//log all attempts
mysqli_query($conn,"insert into LoginAttempt (IPAddress, AttemptTime, Username) values ('$sIPAddress', '$sAttemptTime', '$sUsername')");


?>
