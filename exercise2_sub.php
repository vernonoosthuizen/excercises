<?php
/**
 * Created by PhpStorm.
 * User: Vernon Oosthuizen
 * Date: 2018/05/02
 * Time: 10:12 AM
 */

function fibonacci($number)
{
    if ($number == 0) return 0;
    elseif ($number == 1) return 1;

    return fibonacci($number-2)+fibonacci($number-1);

}

for ($i=0; $i<10; $i++)
    echo fibonacci($i).' ';
