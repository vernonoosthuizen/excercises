<?php
/**
 * Created by PhpStorm.
 * User: Vernon Oosthuizen
 * Date: 2018/05/03
 * Time: 5:09 PM
 */

session_start();

$conn = mysqli_connect('localhost', 'vernon', 'v3rn0n', 'trainingExercise', 3307);
if (!$conn) die('Connection Failed!');

// VON: TODO: this should move to another page maybe
#investigate prepared statements as alternatives
foreach ($_POST as $key=>$value) {
    $_POST[$key] = mysqli_real_escape_string($conn, $value);
}

?>