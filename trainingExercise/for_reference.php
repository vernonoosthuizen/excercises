<?php
/**
 * Created by PhpStorm.
 * User: stratusolve
 * Date: 2018/05/08
 * Time: 2:47 PM
 */

$HashedPassword = password_hash("1234",CRYPT_SHA256);
$isCorrect = password_verify("123",$HashedPassword);
echo $isCorrect ? "Yay! $isCorrect":"Awh $isCorrect";
echo "<br>Hasshed: $HashedPassword";