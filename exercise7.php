<?php
/**
 * Created by PhpStorm.
 * User: Vernon Oosthuizen
 * Date: 2018/05/02
 * Time: 4:34 PM
 */

# DATABASE CONNECTION
$conn = mysqli_connect('localhost', 'vernon', 'v3rn0n','exercise6', 3306);

if (!$conn) die('Connection failed');

# CLASS
class Person{

    var $Firstname, $Surname, $DateOfBirth, $EmailAddress = '';
    var $Age, $id = 0;

    function createPerson(){
        global $conn;
        mysqli_query($conn, "insert into Person (Firstname, Surname, DateOfBirth, EmailAddress, Age) values ('$this->Firstname', '$this->Surname', '$this->DateOfBirth', '$this->EmailAddress', $this->Age)");
    }

    function loadPerson(){
        global $conn;
        $Result = mysqli_query($conn, "select Firstname, Surname, DateOfBirth, EmailAddress, Age from Person where id=$this->id");
        $Details = mysqli_fetch_assoc($Result);
        $this->Firstname = $Details['Firstname'];
        $this->Surname = $Details['Surname'];
        $this->DateOfBirth = date('Y-m-d', strtotime($Details['DateOfBirth']));
        $this->EmailAddress = $Details['EmailAddress'];
        $this->Age = $Details['Age'];
    }

    function savePerson(){
        global $conn;
        mysqli_query($conn, "update Person set Firstname='$this->Firstname', Surname='$this->Surname', DateOfBirth='$this->DateOfBirth', EmailAddress='$this->EmailAddress', Age=$this->Age where id=$this->id");
    }

    function deletePerson(){
        global $conn;
        mysqli_query($conn, "delete from Person where id=$this->id");
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

# INPUT
$sCommand = isset($_POST['command']) ? $_POST['command'] : '';
$iPersonID = isset($_POST['PersonID']) ? $_POST['PersonID'] : 0;
$sFirstname = isset($_POST['Firstname']) ? $_POST['Firstname'] : '';
$sSurname = isset($_POST['Surname']) ? $_POST['Surname'] : '';
$sDateOfBirth = isset($_POST['DateOfBirth']) ? $_POST['DateOfBirth'] : '';
$sEmailAddress = isset($_POST['EmailAddress']) ? $_POST['EmailAddress'] : '';
$iAge = isset($_POST['Age']) ? $_POST['Age'] : 0;

# PROCESSING
if ($sCommand == 'Edit' && $iPersonID) {
    $oPerson = new Person();
    $oPerson->id = $iPersonID;
    $oPerson->loadPerson();
    echo json_encode(array('Firstname'=>$oPerson->Firstname, 'Surname'=>$oPerson->Surname, 'DateOfBirth'=>$oPerson->DateOfBirth, 'EmailAddress'=>$oPerson->EmailAddress, 'Age'=>$oPerson->Age));
    die;
}
elseif ($sCommand == 'Update' && $iPersonID) {
    $oPerson = new Person();
    $oPerson->id = $iPersonID;
    $oPerson->Firstname = $sFirstname;
    $oPerson->Surname = $sSurname;
    $oPerson->DateOfBirth = $sDateOfBirth;
    $oPerson->EmailAddress = $sEmailAddress;
    $oPerson->Age = $iAge;
    $oPerson->savePerson();
    die;
}
elseif ($sCommand == 'Delete' && $iPersonID)
{
    $oPerson = new Person();
    $oPerson->id = $iPersonID;
    $oPerson->deletePerson();
    die;
}
elseif ($sCommand == 'Add')
{
    echo 'adding';
    $oPerson = new Person();
    $oPerson->Firstname = $sFirstname;
    $oPerson->Surname = $sSurname;
    $oPerson->DateOfBirth = $sDateOfBirth;
    $oPerson->EmailAddress = $sEmailAddress;
    $oPerson->Age = $iAge+0;
    $oPerson->createPerson();
    die;
}

#OUTPUT
echo <<<JS
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">

function addPerson()
{
    $.post('exercise7.php', {
        'command': 'Add',
        'Firstname': $('#Firstname').val(),
        'Surname': $('#Surname').val(),
        'DateOfBirth': $('#DateOfBirth').val(),
        'EmailAddress': $('#EmailAddress').val(),
        'Age': $('#Age').val()
    }, function(data){ window.location=window.location; });
}

function editPerson(PersonID)
{
    $.post('exercise7.php', {
        'command': 'Edit', 
        'PersonID': PersonID
        }, function(data){
            $('#Firstname').val(data.Firstname);
            $('#Surname').val(data.Surname);
            $('#DateOfBirth').val(data.DateOfBirth);
            $('#EmailAddress').val(data.EmailAddress);
            $('#Age').val(data.Age);
            
            $('#AddBtn').hide();
            $('#SaveBtn').show();
            $('#SaveBtn').on('click', function(){ updatePerson(PersonID); });
          //  $('#AddSaveBtn').on('click', function(){ updatePerson(PersonID) });
            $('#CancelBtn').show();
        }, "json");
}

function clearFields()
{
    $('#Firstname').val('');
    $('#Surname').val('');
    $('#DateOfBirth').val('');
    $('#EmailAddress').val('');
    $('#Age').val('');
    
    $('#AddBtn').show();
    $('#SaveBtn').hide();
    $('#CancelBtn').hide();
}

function updatePerson(PersonID)
{
    $.post('exercise7.php', {
        'command': 'Update',
        'PersonID': PersonID,
        'Firstname': $('#Firstname').val(),
        'Surname': $('#Surname').val(),
        'DateOfBirth': $('#DateOfBirth').val(),
        'EmailAddress': $('#EmailAddress').val(),
        'Age': $('#Age').val()
    }, function(){ window.location=window.location; });
}

</script>
JS;


echo '<table>
<tr>
    <th colspan="7"></th>
</tr>
<tr>
    <td style="font-weight: bold;">Firstname</td>
    <td style="font-weight: bold;">Surname</td>
    <td style="font-weight: bold;">Date Of Birth</td>
    <td style="font-weight: bold;">Email Address</td>
    <td style="font-weight: bold; text-align: center">Age</td>
    <td></td>
    <td></td>
</tr>';
$People = mysqli_query($conn, "select id from Person");
while ($PeopleID = mysqli_fetch_assoc($People)) {
    $Person = new Person();
    $Person->id = $PeopleID['id'];
    $Person->loadPerson();
    echo <<<HTML
    <tr>
        <td>$Person->Firstname</td>
        <td>$Person->Surname</td>
        <td>$Person->DateOfBirth</td>
        <td>$Person->EmailAddress</td>
        <td style="text-align: center">$Person->Age</td>
        <td style="text-align: center"><input type="button" value="Edit" onclick="editPerson($Person->id)"></td>
        <td style="text-align: center"><input type="button" value="Delete" onclick="if (confirm('Are you sure you want to delete this?')) { $.post('exercise7.php', {'command': 'Delete', 'PersonID': $Person->id}, function(){ window.location=window.location;});}"></td>
    </tr>
HTML;
}

echo <<<HTML
<tr>
    <td><input type="text" name="Firstname" id="Firstname"></td>
    <td><input type="text" name="Surname" id="Surname"></td>
    <td><input type="text" name="DateOfBirth" id="DateOfBirth"></td>
    <td><input type="text" name="EmailAddress" id="EmailAddress"></td>
    <td><input type="text" name="Age" id="Age"></td>
    <td><input type="button" value="Add" id="AddBtn" onclick="addPerson()"><input type="button" value="Update" id="SaveBtn" style="display: none;"></td>
    <td><input type="button" value="Cancel" id="CancelBtn" style="display:none;" onclick="clearFields()"></td>
</tr>
</table> 
HTML;

?>