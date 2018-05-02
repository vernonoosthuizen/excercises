<?php
/**
 * Created by PhpStorm.
 * User: Vernon Oosthuizen
 * Date: 2018/05/02
 * Time: 2:15 PM
 */

$ScriptStart = microtime(true);
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

person::deleteAllPeople();

for ($i=0; $i < 10; $i++)
{
    $person = new Person();
    $person->Firstname = 'Firstname'.$i;
    $person->Surname = 'Surname'.$i;
    $person->DateOfBirth = date("Y-m-d H:i:s", time() - 60*60*24*3650*$i);
    $person->EmailAddress = 'email'.$i.'@test.com';
    $person->Age = 10*$i;
    $person->createPerson();
}

echo '<table>
<tr><th colspan="5">People</th></tr>
<tr>
    <td style="font-weight: bold;">Firstname</td>
    <td style="font-weight: bold;">Surname</td>
    <td style="font-weight: bold;">EmailAddress</td>
    <td style="text-align: center; font-weight: bold;">DateOfBirth</td>
    <td style="text-align: center; font-weight: bold;">Age</td>
</tr>';
foreach (person::loadAllPeople() as $PersonDetails)
{
    echo <<<HTML
    <tr>
        <td>$PersonDetails[Firstname]</td>
        <td>$PersonDetails[Surname]</td>
        <td>$PersonDetails[EmailAddress]</td>
        <td style="text-align: center">$PersonDetails[DateOfBirth]</td>
        <td style="text-align: center">$PersonDetails[Age]</td>
    </tr>
HTML;

}

echo '</table>';
$ScriptEnd = microtime(true);
echo 'Start Time: '.date('Y-m-d H:i:s', $ScriptStart)." ($ScriptStart)";
echo '<br>End Time: '.date('Y-m-d H:i:s', $ScriptEnd)." ($ScriptEnd)";
echo '<br>Total Time: '.floatval($ScriptEnd - $ScriptStart).' seconds';
mysqli_close($conn);
?>