<?php
/**
 * Created by PhpStorm.
 * User: Vernon Oosthuizen
 * Date: 2018/05/02
 * Time: 9:32 AM
 */

$maximumNumber = isset($_POST['maximum']) ? $_POST['maximum'] : 34;

function fibonacci($number)
{
    if ($number == 0) return 0;
    elseif ($number == 1) return 1;

    $first = 0;
    $second = 1;

    for ($i=1; $i < $number; $i++){
        $placeholder = $first;
        $first = $second;
        $second += $placeholder;
    }

    return $second;
}

$i=0;
while ($i < $maximumNumber) {
    $holder = fibonacci($i);
    if ($holder > $maximumNumber) $i = $maximumNumber;
    else{
        $i++;
        echo $holder. ' ';
    }
}

