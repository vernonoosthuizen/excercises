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
    return fibonacci($number-2)+fibonacci($number-1);
}

$i = $counter = 0;
while ($counter <= $maximumNumber) {
    $holder = fibonacci($i);

    if ($holder > $maximumNumber) {
        $counter = $maximumNumber + 1;
    } else {
        echo $holder . ' ';
        $i++;
    }
}

