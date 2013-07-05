<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 08-05-13
 * Time: 12:18
 * To change this template use File | Settings | File Templates.
 */

class IMDb
{

    /**
     * Where to send all the requests to.
     */
    const IMDBAPI = 'http://mymovieapi.com/';

    /**
     * Contains all the data fetched in the request
     * @var SimpleXML file
     */
    private $_IMDBJSON;

    /**
     * Fetches data from the IMDBAPI.org website, creates XML file and stores the information
     *
     * @param $imDbId
     */
    public function getSerieById($imDbId)
    {
        $url = self::IMDBAPI . '?id=' . $imDbId . '&type=json&plot=full&episode=1&lang=en-US&aka=simple&release=simple&business=1&tech=1';
        $this->_IMDBJSON = json_decode(C_URL::get_url_contents($url), true);
        $show = new IMDbShow($this->_IMDBJSON);

        if (sizeof($this->_IMDBJSON['episodes']) > 0) {
            foreach ($this->_IMDBJSON['episodes'] as $ep) {
                $show->episodes[] = new IMDbEpisode($ep);
            }
        }

        return $show;
    }
}