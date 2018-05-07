<?php
/**
 * Created by PhpStorm.
 * User: Vernon Oosthuizen
 * Date: 2018/05/04
 * Time: 9:36 AM
 */

require_once 'connect.php';

if (isset($_SESSION['UserId']) && $_SESSION['UserId']) die('true');

die;
