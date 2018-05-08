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
$rCount = mysqli_query($conn, "select id from LoginAttempt where AttemptTime > '$sTimeTenMinutesAgo' and Username='$sUsername'");
if (mysqli_num_rows($rCount) > 4) die('Login attempts');

if ($sUsername == '' || $sPassword == '')
{

//log all attempts
    mysqli_query($conn,"insert into LoginAttempt (IPAddress, AttemptTime, Username) values ('$sIPAddress', '$sAttemptTime', '$sUsername')");

    header('Location: login.html');
    die('Failed');
}

$Authenticate = mysqli_query($conn,"select id, Password from User where Username='$sUsername'");
while ($aUser = mysqli_fetch_assoc($Authenticate))
{
    if (password_verify($sPassword, $aUser['Password'])) {
        $_SESSION['UserId'] = $aUser['id'];
        die('success');
    }
}

//log all attempts
mysqli_query($conn,"insert into LoginAttempt (IPAddress, AttemptTime, Username) values ('$sIPAddress', '$sAttemptTime', '$sUsername')");


//$HashedPassword = password_hash("123", CRYPT_SHA256);
//$isCorrect = password_verify("123",password_hash("123"));
//echo $isCorrect ? "Yay! $isCorrect":"Awh $isCorrect";
?>
