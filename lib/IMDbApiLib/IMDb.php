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
    const IMDBAPI = 'http://imdbapi.org/';

    /**
     * Contains all the data fetched in the request
     * @var SimpleXML file
     */
    private $_IMDBXML;

    /**
     * Fetches data from the IMDBAPI.org website, creates XML file and stores the information
     *
     * @param $imDbId
     */
    public function getSerieById($imDbId)
    {
        $url = self::IMDBAPI . '?id=' . $imDbId . '&type=xml&plot=full&episode=1&lang=en-US&aka=simple&release=simple&business=1&tech=1';
        $this->_IMDBXML = SimpleXML::get_xml_url_contents($url);

        $show = new IMDbShow($this->_IMDBXML);

        if (sizeof($this->_IMDBXML->episodes) > 0) {
            foreach ($this->_IMDBXML->episodes->item as $ep) {
                $show->episodes[] = new IMDbEpisode($ep);
            }
        }

        return $show;
    }
}