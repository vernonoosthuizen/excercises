<?php
/**
 * Created by PhpStorm.
 * User: Vernon Oosthuizen
 * Date: 2018/05/02
 * Time: 8:37 AM
 */

function addAll($Array) {
    if (count($Array) == 0) return 0;
    $returnValue = 0;

    foreach ($Array as $value) {
        $returnValue += $value;
    }

    array_shift($Array);
    return addAll($Array)+$returnValue;
}

$Array = [1,1,1,1,1]; //5+4+3+2+1=15
echo addAll($Array);
?>