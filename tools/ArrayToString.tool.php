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
     *
     * @param array $array
     */
    public static function getString(array $array)
    {
        $str = '';
        foreach ($array as $key => $var) {
            $str .= $var . ', ';
        }
        return substr($str, 0, strlen($str) - 2);
    }

    /**
     * Generates a string with line breaked values from an array
     *
     * @param array $data
     */
    public static function getStringLineBreakArray($data)
    {
        $str = '';
        foreach ($data as $key => $var) {
            $str .= $var . '[br]';
        }
        return substr($str, 0, strlen($str) - 4);
    }

    /**
     * Used to create a string where its values are seperated by [br]
     *
     * @param SimpleXMLElement $data
     *
     * @return SimpleXMLElement[]|string
     */
    public static function getStringLineBreak($data)
    {
        if (is_array($data)) {
            return self::getStringLineBreakArray($data);
        } else {
            // When its no array its an one-lined string, so we can return this directly without a [br] tag.
            return $data;
        }
    }
}