<?php
/**
 * Created by PhpStorm.
 * User: Vernon Oosthuizen
 * Date: 2018/05/02
 * Time: 10:38 AM
 */

class ItemOwners {
    public static function groupByOwners($items) {
        $owners = [];
        foreach ($items as $item=>$name) $owners[$name][] = $item;

        return $owners;
    }
}

$items = array(
    "Baseball Bat" => "John",
    "Golf ball" => "Stan",
    "Tennis Racket" => "John"
);
echo json_encode(ItemOwners::groupByOwners($items));

?>