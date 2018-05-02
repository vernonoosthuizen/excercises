<?php
/**
 * Created by PhpStorm.
 * User: Vernon Oosthuizen
 * Date: 2018/05/02
 * Time: 4:34 PM
 */

$conn = mysqli_connect('localhost', 'vernon', 'v3rn0n','exercise6', 3306);

if (!$conn) die('Connection failed');

class Person{

    var $Firstname, $Surname, $DateOfBirth, $EmailAddress = '';
    var $Age, $id = 0;

    function createPerson(){
        global $conn;
        mysqli_query($conn, "insert into Person (Firstname, Surname, DateOfBirth, EmailAddress, Age) values ('$this->Firstname', '$this->Surname', '$this->DateOfBirth', '$this->EmailAddress', $this->Age)");
    }

    function loadPerson(){
        global $conn;
    }

    function savePerson(){
        global $conn;
    }

    function deletePerson(){
        global $conn;
    }

    function loadAllPeople(){
        global $conn;
        $Return = [];
        $people = mysqli_query($conn, "select id, Firstname, Surname, EmailAddress, DateOfBirth, Age from Person");
        while ($PersonDetails = mysqli_fetch_assoc($people)) $Return[$PersonDetails['id']] = $PersonDetails;
        return $Return;
    }

    function deleteAllPeople(){
        global $conn;
        mysqli_query($conn, "delete from Person");
    }
}
