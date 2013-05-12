<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 09-05-13
 * Time: 21:38
 * To change this template use File | Settings | File Templates.
 */

class C_URL
{
    /**
     * Defines this application.
     */
    const USERAGENT = 'Ultimation/1.0';

    /**
     * Gets the contents of a URL
     *
     * Attempts to use the following methods:
     *  cURL
     *  fopen
     *  fsockopen
     *
     * Returns boolean false if it fails.
     *
     * @param string $url
     *
     * @return string|false
     */
    public static function get_url_contents($url)
    {
        $contents = NULL;

        // 2xx is successful everything else failed as far as we are concerned
        // so all none 2xx status codes will return false
        ini_set('user_agent', 'Ultimation/1.0'); // for fopen
        if (function_exists('curl_init')) {
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Ultimation/1.0');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $contents = curl_exec($ch);
            $http_code = (string)curl_getinfo($ch, CURLINFO_HTTP_CODE);

            if ($http_code{0} != 2) {
                echo 'HTTP code : ' . $http_code . '<br />';
                return false;
            }

            curl_close($ch);
        } else if (($fp = fopen($url, 'r'))) {
            if (!preg_match("/2[0-9]{2}/", $http_response_header[0])) {
                return false;
            }

            for (; ($data = fread($fp, 8192));) {
                $contents .= $data;
            }

            fclose($fp);
        } elseif (($url_info = parse_url($url))) {
            if ($url_info['scheme'] == 'https') {
                $fp = fsockopen('ssl://' . $url_info['host'], 443, $errno, $errstr, 30);
            } else {
                $fp = fsockopen($url_info['host'], 80, $errno, $errstr, 30);
            }

            if (!$fp) {
                return false;
            }

            $out = 'GET ' . (isset($url_info['path']) ? $url_info['path'] : '/') .
                (isset($url_info['query']) ? '?' . $url_info['query'] : '') . " HTTP/1.0\r\n";
            $out .= "Host: {$url_info['host']}\r\n";
            $out .= "User-Agent: " . self::USERAGENT . "\r\n";
            $out .= "Connection: Close\r\n\r\n";

            fwrite($fp, $out);
            for (; !feof($fp);) {
                $contents .= fread($fp, 8192);
            }

            list($headers, $contents) = preg_split("/(\r\n|\r|\n){2}/", $contents, 2);

            if (!preg_match("/2[0-9]{2}/", $headers[0])) {
                return false;
            }
        } else {
            return false;
        }

        return $contents;
    }
}