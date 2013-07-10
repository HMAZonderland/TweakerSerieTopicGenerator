<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 08-07-13
 * Time: 10:33
 * To change this template use File | Settings | File Templates.
 */

class bierdopje
{
    /**
     * Bierdopje URL + API key
     * @var string
     */
    private $url = 'http://api.bierdopje.com/';

    /**
     *
     */
    public function __construct()
    {
        $this->url .= BIERDOPJE_API_KEY . '/';
    }

    /**
     * @param $tvdb_id
     *
     * @return false|string
     */
    public function getShowByTvDbId($tvdb_id)
    {
        $url = $this->url . 'GetShowByTVDBID/' . $tvdb_id;
        $show = new bierdopjeShow(SimpleXML::get_xml_url_contents($url)->response);
        $show->setShows($this->getEpisodesByBierdopjeId($show->showid));
        return $show;
    }

    /**
     * @param $bierdopje_id
     *
     * @return mixed
     */
    public function getEpisodesByBierdopjeId($bierdopje_id)
    {
        $url = $this->url . 'GetAllEpisodesForShow/' . $bierdopje_id;
        return SimpleXML::get_xml_url_contents($url)->response->results;
    }
}