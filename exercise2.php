<?php
/**
 * Created by PhpStorm.
 * User: Vernon Oosthuizen
 * Date: 2018/04/23
 * Time: 01:53 PM
 */

$iCurrent = 0;
$aValues = [0];
while ($iCurrent < 34)
{
    print_r($aValues);
    echo '<br>';
    if ($iCurrent < 2)
    {
        $iCurrent++;
    }
    else $iCurrent = $aValues[count($aValues)-2] + $iCurrent;

    $aValues[] = $iCurrent;
}

print_r($aValues);