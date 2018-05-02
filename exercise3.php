<?php
/**
 * Created by PhpStorm.
 * User: Vernon Oosthuizen
 * Date: 2018/05/02
 * Time: 10:29 AM
 */

class Palindrome {
    public static function isPalindrome($word) {
        $word = str_replace(' ', '', strtolower($word));
        $reversedWord = strrev($word);
        if ($word === $reversedWord) return true;

        return false;
    }
}

if (Palindrome::isPalindrome('Never Odd Or Even'))
    echo 'Palindrome';
else
    echo 'Not palindrome';
?>