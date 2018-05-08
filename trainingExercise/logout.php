<?php
/**
 * Created by PhpStorm.
 * User: Vernon Oosthuizen
 * Date: 2018/05/04
 * Time: 9:44 AM
 */

require_once 'connect.php';

if (isset($_SESSION['UserId'])) session_destroy();

header('Location: login.html');
die;
?>