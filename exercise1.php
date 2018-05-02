<?php
/**
 * Created by PhpStorm.
 * User: Vernon Oosthuizen
 * Date: 2018/05/02
 * Time: 8:23 AM
 */

function addAll($Array) {
    $returnValue = 0;
    while (count($Array) > 0) {
        foreach ($Array as $key=>$value) $returnValue += $value;
        array_shift($Array);
    }
    return $returnValue;
}

$Array = [1,1,1,1,1]; //5+4+3+2+1=15

echo addAll($Array);

?>