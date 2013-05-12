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
     *
     * @param TvDbShow $tvdb
     * @param IMDbShow $imdb
     */
    public function __construct(TvDbShow $tvdb, IMDbShow $imdb)
    {
        $this->_tvdb = $tvdb;
        $this->_imdb = $imdb;
    }

    /**
     * Searches by tvdbId, creates IMDbShow and TvDbShow objects uses both to create a TweakersSerie object
     *
     * @param $tvdbId
     *
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
     * Collects all general information about the serie and returns this in an array
     * @return array
     */
    public function getGeneralInformation()
    {
        $genres             = $this->getGenresAsString();
        $imdbRatings        = $this->_imdb->rating;
        $imdbVotes          = $this->_imdb->rating_count;
        $tvdbRatings        = $this->_tvdb->rating;
        $tvdbVotes          = $this->_tvdb->rating_count;
        $status             = $this->getStatus();
        $network            = $this->getNetwork();
        $first_air_date     = $this->getFirstAirDate();
        $filming_locations  = $this->getFilmingLocations();
        $runtime            = $this->getRuntime();
        $languages          = $this->getLanguagesAsString();

        $array = array();

        if (strlen($network) > 0)           $array['Uitgever'] = $network;
        if (strlen($genres) > 0)            $array['Genre'] = $genres;
        if (strlen($first_air_date) > 0)    $array['Begonnen'] = $first_air_date;
        if (strlen($imdbRatings) > 0)       $array['IMDb cijfer'] = $imdbRatings . " (" . $imdbVotes . " stemmen)";
        if (strlen($tvdbRatings) > 0)       $array['TvDb cijfer'] = $tvdbRatings . " (" . $tvdbVotes . " stemmen)";
        if (strlen($status) > 0)            $array['Status'] = $status;
        if (strlen($filming_locations) > 0) $array['Film locaties'] = $filming_locations;
        if (strlen($runtime) > 0)           $array['Speeltijd'] = $runtime;
        if (strlen($languages) > 0)         $array['Uitgebracht in talen'] = $languages;

        return $array;
    }

    /**
     * Collects more technical information about the serie and returns this in an array
     * @return array
     */
    public function getTechnicalInformation()
    {
        $ratio                      = $this->getRatio();
        $cinematographic_process    = $this->getCinematographicProcessAsString();
        $cameras                    = $this->getCameraAsString();
        $printed_film_format        = $this->getPrintedFilmFormat();
        $film_negativ_format        = $this->getFilmNegativeFormat();
        $laboratory                 = $this->getLaboratory();

        $array = array();

        if (strlen($ratio) > 0)                     $array['Ratio'] = $ratio;
        if (strlen($cinematographic_process) > 0)   $array['Cinematografische proces'] = $cinematographic_process;
        if (strlen($cameras) > 0)                   $array['Camera\'s'] = $cameras;
        if (strlen($printed_film_format) > 0 )      $array['Film formaat'] = $printed_film_format;
        if (strlen($film_negativ_format) > 0)       $array['Negatief'] = $film_negativ_format;
        if (strlen($laboratory) > 0)                $array['Laboratorium'] = $laboratory;

        return $array;
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
        return ArrayToString::getStringLineBreakArray($this->getGenres());
    }

    /**
     * @return mixed
     */
    public function getFilmingLocations()
    {
        return $this->_imdb->filming_locations;
    }

    /**
     * @return mixed
     */
    public function getRuntime()
    {
        return $this->_imdb->runtime->item;
    }

    /**
     * Returns the link to the TVDb
     * @return string
     */
    public function getTvDbUrl()
    {
        return $this->_tvdb->tvdb_url;
    }

    /**
     * Returns the link to IMDb
     * @return SimpleXMLElement[]
     */
    public function getIMDbUrl()
    {
        return $this->_imdb->imdb_url;
    }

    /**
     * @return mixed
     */
    public function getRatio()
    {
        return $this->_imdb->aspect_ratio;
    }

    /**
     * @return string
     */
    public function getCinematographicProcessAsString()
    {
        return ArrayToString::getStringLineBreak($this->_imdb->cinematographic_process);
    }

    /**
     * @return string
     */
    public function getCameraAsString()
    {
        return ArrayToString::getStringLineBreak($this->_imdb->camera);
    }

    /**
     * @return mixed
     */
    public function getPrintedFilmFormat()
    {
        return ArrayToString::getStringLineBreak($this->_imdb->printed_film_format);
    }

    /**
     *
     */
    public function getFilmNegativeFormat()
    {
        return ArrayToString::getStringLineBreak($this->_imdb->film_negative_format);
    }

    /**
     *
     */
    public function getLaboratory()
    {
        return ArrayToString::getStringLineBreak($this->_imdb->laboratory);
    }

    public function getLanguagesAsString()
    {
        return ArrayToString::getStringLineBreak($this->_imdb->language);
    }
}