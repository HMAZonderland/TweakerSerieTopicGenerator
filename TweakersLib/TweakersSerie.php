<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 09-05-13
 * Time: 23:25
 * To change this template use File | Settings | File Templates.
 */

class TweakersSerie
{
    /**
     * TvDbShow var
     * @var TvDbShow
     */
    private $_tvdb;

    /**
     * IMDbShow var
     * @var IMDbShow
     */
    private $_imdb;

    /**
     * Sets up the object
     * @param TvDbShow $tvdb
     * @param IMDbShow $imdb
     */
    public function __construct(TvDbShow $tvdb, IMDbShow $imdb) {
        $this->_tvdb = $tvdb;
        $this->_imdb = $imdb;
    }

    /**
     * Searches by tvdbId, creates IMDbShow and TvDbShow objects uses both to create a TweakersSerie object
     * @param $tvdbId
     * @return TweakersSerie
     */
    public static function getSerieByTvDbId($tvdbId)
    {
        $tvdb = new TVDb();
        $imdb = new IMDb();

        $tvdbShow = $tvdb->get_tv_show_by_id($tvdbId);
        $imDbShow = $imdb->getSerieById($tvdbShow->IMDB_id);

        return new TweakersSerie($tvdbShow, $imDbShow);
    }

    /**
     * Return the serie name
     * @return string
     */
    public function getName()
    {
        if (strlen($this->_tvdb->name) > 0) {
            return $this->_tvdb->name;
        }
        return $this->_imdb->title;
    }

    /**
     * Returns serie banner
     * @return string
     */
    public function getBanner()
    {
        return $this->_tvdb->banner;
    }

    /**
     * Returns first date aired
     * @return string
     */
    public function getFirstAirDate()
    {
        return $this->_tvdb->first_aired;
    }

    /**
     * Returns the network making the serie
     * @return string
     */
    public function getNetwork()
    {
        return $this->_tvdb->network;
    }

    /**
     * Returns the serie status
     * @return string
     */
    public function getStatus()
    {
        return $this->_tvdb->status;
    }

    /**
     * Returns an array with all the actors playing in the serie
     * @return array
     */
    public function getActors()
    {
        return $this->_tvdb->actors;
    }

    /**
     * Checks if IMDb of TVDb as the longest serie intro, returns the longest
     * @return SimpleXMLElement[]|string
     */
    public function getLongestPlot()
    {
        if (strlen($this->_imdb->plot) > strlen($this->_tvdb->overview)) {
            return $this->_imdb->plot;
        }
        return $this->_tvdb->overview;
    }

    /**
     * Combines all the genres on both IMDb and TVDb to one array
     * @return array
     */
    public function getGenres()
    {
        $genres = array();

        $tvdbGenres = $this->_tvdb->genre;
        $imdbGenres = $this->_imdb->genres;

        foreach ($tvdbGenres as $tvdbGenre) {
            array_push($genres, $tvdbGenre);
        }

        foreach ($imdbGenres as $imdbGenre) {
            if (($key = array_search($imdbGenre, $genres)) == null) {
                array_push($genres, $imdbGenre);
            }
        }

        return $genres;
    }

    /**
     * Returns all the series genres in 1 string comma seperated
     * @return string
     */
    public function getGenresAsString()
    {
        $s = '';
        $genres = $this->getGenres();
        foreach ($genres as $genre) {
            $s += $genre . ', ';
        }
        return substr($s, 0, strlen($s) - 1);
    }

    /**
     * Returns a multidimensional array with ratings per used channel
     * @return array
     */
    public function getRatings()
    {
        $ratings = array();

        $ratings['imdb'] = array();
        $ratings['imdb']['rating'] = $this->_imdb->rating;
        $ratings['imdb']['count'] = $this->_imdb->rating_count;

        $ratings['tvdb'] = array();
        $ratings['tvdb']['rating'] = $this->_tvdb->rating;
        $ratings['tvdb']['count'] = $this->_tvdb->rating_count;

        return $ratings;
    }


}