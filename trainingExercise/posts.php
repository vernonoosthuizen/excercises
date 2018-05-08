<?php
/**
 * Created by PhpStorm.
 * User: Vernon Oosthuizen
 * Date: 2018/05/04
 * Time: 1:17 PM
 */

require_once 'connect.php';
require_once 'classes/classUser.php';
require_once 'classes/classPost.php';

#INPUT
$iUserId = isset($_SESSION['UserId']) ? $_SESSION['UserId'] : 0;
$sCommand = isset($_POST['command']) ? $_POST['command'] : '';
$sPostText = isset($_POST['PostText']) ? htmlentities(trim($_POST['PostText']), ENT_NOQUOTES) : '';
$iLimit = isset($_POST['Limit']) ? (int)$_POST['Limit'] : 0;
$iOffset = isset($_POST['Offset']) ? (int)$_POST['Offset'] : 0;


#PROCESSING
if (!$iUserId) die;

if ($sCommand == 'Create' && $sPostText != '')
{
    $oPost = new Post();
    $oPost->iUserPostedId = $iUserId;
    $oPost->sPostText = $sPostText;
    $oPost->sPostTimeStamp = date('Y-m-d H:i:s');
    $oPost->createPost();
    die;
}
elseif ($sCommand == 'GetAllPosts'){
    $oPost = new Post();
    $iTotalPosts = $oPost->getAllPosts($iLimit, $iOffset);
    $iNewOffset = $iOffset+$iLimit;
    if ($iTotalPosts == 0) echo '<em>No posts yet.</em>';
    if ($iTotalPosts >= $iNewOffset) {
        echo <<<HTML
        <div id="loading$iNewOffset" style="width: 100%; text-align: center; display: none;"><i class="fa fa-spinner fa-spin" style="font-size:46px;"></i></div>
        <div id="ReadMore"><br>
        <button type="button" class="btn btn-primary pull-right" onclick="$.post('posts.php', {'command': 'GetAllPosts', 'Limit': $iLimit, 'Offset': $iNewOffset}, function(response) {
            $('#ReadMore').remove();
            $('#loading{$iNewOffset}').fadeIn();
            $('#PostListDiv').append(response);
            $('#loading{$iNewOffset}').fadeOut(function(){ 
                $('#loading{$iNewOffset}').remove();
            });
        });">Read More ...</button>
        </div>
HTML;
    }
}else{
    header('Location: index.html');
    die;
}