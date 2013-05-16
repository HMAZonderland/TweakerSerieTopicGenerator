<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 09-05-13
 * Time: 21:37
 * To change this template use File | Settings | File Templates.
 */

class SimpleXML
{
    /**
     * Gets the contents of a URL and returns the simplexml parsed result
     *
     * @param string $url
     *
     * @return SimpleXMLElement|false
     */
    public static function get_xml_url_contents($url)
    {
        $data = C_URL::get_url_contents($url);

        if ($data === false) {
            return false;
        }

        return simplexml_load_string($data);
    }

    /**
     * Converts a SimpleXMLElement to an array
     *
     * @param SimpleXMLElement $object
     *
     * @return array
     */
    public static function SimpleXMLElementToArray($object)
    {
        $array = array();

        if ($object != null) {
            foreach ($object as $key => $var) {
                array_push($array, $var);
            }
        }
        return $array[0];

    }
}