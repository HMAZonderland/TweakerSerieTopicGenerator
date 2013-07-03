<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 26-05-13
 * Time: 16:54
 * Debug class used for debugging. Can be used to output strings or to view objects/arrays
 */

/**
 * Class Debug
 */
class Debug
{
    /**
     * @param string $s
     */
    public static function s($s)
    {
        echo $s . "<br />";
    }

    /**
     * @param Object|array $a
     */
    public static function p($a)
    {
        echo "<pre>";
        print_r($a);
    }
}