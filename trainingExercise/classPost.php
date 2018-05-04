<?php
/**
 * Created by PhpStorm.
 * User: Vernon Oosthuizen
 * Date: 2018/05/04
 * Time: 1:48 PM
 */

class Post{
    var $iPostId, $iUserPostedId = 0;
    var $sPostText, $sPostTimeStamp = '';

    function createPost(){
        global $conn;
        mysqli_query($conn,"insert into Post (PostTimeStamp, PostText, UserId) values ('$this->sPostTimeStamp', '$this->sPostText', $this->iUserPostedId)");
    }

    function getPost(){
        global $conn;
        $rResult = mysqli_query($conn, "select PostTimeStamp, PostText, UserId from Post where id=$this->iPostId");
        if ($aPost = mysqli_fetch_assoc($rResult)) {
            $this->sPostText = $aPost['PostText'];
            $this->iUserPostedId = $aPost['UserId'];
            $this->sPostTimeStamp = $aPost['PostTimeStamp'];
        }
    }

    function getAllPosts(){
        global $conn;
        $rResult = mysqli_query($conn, "select id, UserId from Post order by id desc");
        while ($aPost = mysqli_fetch_assoc($rResult)) {
            $oPost = new Post();
            $oPost->iPostId = $aPost['id'];
            $oPost->getPost();
            echo $oPost->displayPost();
        }
    }

    function displayPost(){
        $sTimeAgo = '';
        $oDateTimeNow = new DateTime(date('Y-m-d H:i:s'));
        $oDateTimePost = new DateTime($this->sPostTimeStamp);
        $oTimeAgo = $oDateTimeNow->diff($oDateTimePost);
        foreach ($oTimeAgo as $key=>$value)
        {
           if ($value) {
                $sTimeAgo = $value;
                switch($key)
                {
                    case 'y' : $sTimeAgo .= ($value) > 1 ? ' years ago' : ' year ago'; break;
                    case 'm' : $sTimeAgo .= ($value) > 1 ? ' months ago' : ' month ago'; break;
                    case 'd' : $sTimeAgo .= ($value) > 1 ? ' days ago' : ' day ago'; break;
                    case 'h' : $sTimeAgo .= ($value) > 1 ? ' hours ago' : ' hour ago'; break;
                    case 'i' : $sTimeAgo .= ($value) > 1 ? ' min ago' : ' min ago'; break;
                    case 's' : $sTimeAgo .= ($value) > 1 ? ' sec ago' : ' sec ago'; break;
                    default: $sTimeAgo .= 'Just now';
                }
                break;
            }
            else $sTimeAgo = 'Just now';
        }

        $oUser = new User();
        $oUser->iUserId = $this->iUserPostedId;
        $oUser->getUser();
        return <<<HTML
        <div class="media">
            <div class="media-left">
                    <img class="media-object" src="profile pictures/image.png" alt="Profile Picture">
            </div>
            <div class="media-body">
                <div class="time">$sTimeAgo</div>
                <h5 class="media-heading">$oUser->sFirstName $oUser->sLastName</h5>
                $this->sPostText
             </div>
        </div>
HTML;

    }
}
