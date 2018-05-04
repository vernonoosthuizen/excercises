<?php
/**
 * Created by PhpStorm.
 * User: Vernon Oosthuizen
 * Date: 2018/05/04
 * Time: 1:17 PM
 */

require_once 'connect.php';
require_once 'classUser.php';
require_once 'classPost.php';

#INPUT
$iUserId = isset($_SESSION['UserId']) ? $_SESSION['UserId'] : 0;
$sCommand = isset($_POST['command']) ? $_POST['command'] : '';
$sPostText = isset($_POST['PostText']) ? $_POST['PostText'] : '';

#PROCESSING
$oPost = new Post();

if ($sCommand == 'Create' && $sPostText != '')
{
    $oPost->iUserPostedId = $iUserId;
    $oPost->sPostText = $sPostText;
    $oPost->sPostTimeStamp = date('Y-m-d H:i:s');
    $oPost->createPost();
    die;
}
elseif ($sCommand == 'GetAllPosts'){
    $oPost->getAllPosts();
}