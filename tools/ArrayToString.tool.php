<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 11-05-13
 * Time: 22:19
 * To change this template use File | Settings | File Templates.
 */

class ArrayToString
{
    /**
     * Generates a string with comma seperated values from array
     * @param array $array
     */
    public static function getString(array $array)
    {
        $str = '';
        foreach ($array as $var) {
            $str .= $var . ', ';
        }
        substr($str, 0, strlen($str) - 2);
    }

    /**
     * Generates a string with line breaked values from array
     * @param array $array
     */
    public static function getStringLineBreak(array $array)
    {
        $str = '';
        foreach ($array as $var) {
            $str .= $var . '[br]';
        }
        substr($str, 0, strlen($str) - 4);
    }
}