<?php
/**
 * Created by PhpStorm.
 * User: Vernon Oosthuizen
 * Date: 2018/05/04
 * Time: 3:03 PM
 */

class User{
    var $iUserId = 0;
    var $sFirstName, $sLastName, $sEmailAddress, $sUsername, $sPassword = '';

    function getUser(){
        global $conn;
        $rResult = mysqli_query($conn, "select FirstName, LastName, EmailAddress, Username, Password from User where id=$this->iUserId");
        if ($aUser = mysqli_fetch_assoc($rResult)) {
            $this->sFirstName = $aUser['FirstName'];
            $this->sLastName = $aUser['LastName'];
            $this->sEmailAddress = $aUser['EmailAddress'];
            $this->sUsername = $aUser['Username'];
            $this->sPassword = $aUser['Password'];
        }
    }

    function updateUser(){
        global $conn;
        $sPasswordSQL = ($this->sPassword != '') ? ", Password='$this->sPassword'" : '';
        mysqli_query($conn, "update User set FirstName='$this->sFirstName', LastName='$this->sLastName', EmailAddress='$this->sEmailAddress', Username='$this->sUsername' $sPasswordSQL where id=$this->iUserId");
    }
}