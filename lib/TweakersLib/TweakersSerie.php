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
     * Returns an array with all the actors playing in the serie
     * @return array
     */
    public function getActors()
    {
        // More complete data than IMDb has
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
        $genres = $this->getGenresAsString();
        $imdbRatings = $this->_imdb->rating;
        $imdbVotes = $this->_imdb->rating_count;
        $tvdbRatings = $this->_tvdb->rating;
        $tvdbVotes = $this->_tvdb->rating_count;
        $status = $this->getStatus();
        $network = $this->getNetwork();
        $first_air_date = $this->getFirstAirDate();
        $filming_locations = $this->getFilmingLocations();
        $runtime = $this->getRuntime();
        $languages = $this->getLanguagesAsString();

        $array = array();

        if (strlen($network) > 0) $array['Uitgever'] = $network;
        if (strlen($genres) > 0) $array['Genre'] = $genres;
        if (strlen($first_air_date) > 0) $array['Begonnen'] = $first_air_date;
        if (strlen($imdbRatings) > 0) $array['IMDb cijfer'] = $imdbRatings . " (" . $imdbVotes . " stemmen)";
        if (strlen($tvdbRatings) > 0) $array['TvDb cijfer'] = $tvdbRatings . " (" . $tvdbVotes . " stemmen)";
        if (strlen($status) > 0) $array['Status'] = $status;
        if (strlen($filming_locations) > 0) $array['Film locaties'] = $filming_locations;
        if (strlen($runtime) > 0) $array['Speeltijd'] = $runtime;
        if (strlen($languages) > 0) $array['Uitgebracht in talen'] = $languages;

        return $array;
    }

    /**
     * Returns all the series genres in 1 string comma seperated
     * @return string
     */
    private function getGenresAsString()
    {
        return ArrayToString::getStringLineBreakArray($this->getGenres());
    }

    /**
     * Combines all the genres on both IMDb and TVDb to one array
     * @return array
     */
    private function getGenres()
    {
        $genres = array();

        $tvdbGenres = $this->_tvdb->genre;
        $imdbGenres = SimpleXML::SimpleXMLElementToArray($this->_imdb->genres);

        if (sizeof($tvdbGenres) > 0) {
            foreach ($tvdbGenres as $tvdbGenre) {
                array_push($genres, $tvdbGenre);
            }
        }

        if (is_array($imdbGenres)){
            if (sizeof($imdbGenres) > 0) {
                foreach ($imdbGenres as $imdbGenre) {
                    if (($key = array_search($imdbGenre, $genres)) == null) {
                        array_push($genres, $imdbGenre);
                    }
                }
            }
        } else {
            $imdbGenre = $imdbGenres;
            if (($key = array_search($imdbGenre, $genres)) == null) {
                array_push($genres, $imdbGenre);
            }
        }

        return $genres;
    }

    /**
     * Returns the serie status
     * @return string
     */
    private function getStatus()
    {
        return $this->_tvdb->status;
    }

    /**
     * Returns the network making the serie
     * @return string
     */
    private function getNetwork()
    {
        return $this->_tvdb->network;
    }

    /**
     * Returns first date aired
     * @return string
     */
    private function getFirstAirDate()
    {
        return $this->_tvdb->first_aired;
    }

    /**
     * Returns the filming locations
     * @return mixed
     */
    private function getFilmingLocations()
    {
        return $this->_imdb->filming_locations;
    }

    /**
     * Returns the runtime of an episode
     * @return mixed
     */
    private function getRuntime()
    {
        return $this->_imdb->runtime;
    }

    /**
     * Returns all languages this serie is brought out with
     * @return SimpleXMLElement[]|string
     */
    private function getLanguagesAsString()
    {
        return ArrayToString::getStringLineBreak($this->_imdb->language);
    }

    /**
     * Collects more technical information about the serie and returns this in an array
     * @return array
     */
    public function getTechnicalInformation()
    {
        $ratio = $this->getRatio();
        $cinematographic_process = $this->getCinematographicProcessAsString();
        $cameras = $this->getCameraAsString();
        $printed_film_format = $this->getPrintedFilmFormat();
        $film_negativ_format = $this->getFilmNegativeFormat();
        $laboratory = $this->getLaboratory();

        $array = array();

        if (strlen($ratio) > 0) $array['Ratio'] = $ratio;
        if (strlen($cinematographic_process) > 0) $array['Cinematografische proces'] = $cinematographic_process;
        if (strlen($cameras) > 0) $array['Camera\'s'] = $cameras;
        if (strlen($printed_film_format) > 0) $array['Film formaat'] = $printed_film_format;
        if (strlen($film_negativ_format) > 0) $array['Negatief'] = $film_negativ_format;
        if (strlen($laboratory) > 0) $array['Laboratorium'] = $laboratory;

        return $array;
    }

    /**
     * Returns the ratio used
     * @return mixed
     */
    private function getRatio()
    {
        return ArrayToString::getStringLineBreak(SimpleXML::SimpleXMLElementToArray($this->_imdb->aspect_ratio));
    }

    /**
     * Returns the cinematographic process
     * @return string
     */
    private function getCinematographicProcessAsString()
    {
        return ArrayToString::getStringLineBreak(SimpleXML::SimpleXMLElementToArray($this->_imdb->cinematographic_process));
    }

    /**
     * Returns all camera's used in a string
     * @return string
     */
    private function getCameraAsString()
    {
        return ArrayToString::getStringLineBreak(SimpleXML::SimpleXMLElementToArray($this->_imdb->camera));
    }

    /**
     * Returns which film format the serie is produced on
     * @return mixed
     */
    private function getPrintedFilmFormat()
    {
        return ArrayToString::getStringLineBreak(SimpleXML::SimpleXMLElementToArray($this->_imdb->printed_film_format));
    }

    /**
     * Returns which negativ the film is printed on
     * @return SimpleXMLElement[]|string
     */
    private function getFilmNegativeFormat()
    {
        return ArrayToString::getStringLineBreak(SimpleXML::SimpleXMLElementToArray($this->_imdb->film_negative_format));
    }

    /**
     * Returns laboratories used for the series
     * @return SimpleXMLElement[]|string
     */
    private function getLaboratory()
    {
        return ArrayToString::getStringLineBreak($this->_imdb->laboratory);
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
     * Creates an array containing all the episodes per season.
     *
     * @return array
     */
    public function getEpisodesData()
    {
        // Optimized array to process in the UBB code
        $episodes = array();

        // I know the TvDb offers more detailed information about the episode than IMDb does, so we go for that array.
        foreach ($this->_tvdb->episodes as $episode) {
            // No need for the specials
            if ($episode->season_number > 0) {
                $episodes[$episode->season_number][$episode->episode_number]['Seizoen'] = $episode->season_number;
                $episodes[$episode->season_number][$episode->episode_number]['Aflevering'] = $episode->episode_number;
                $episodes[$episode->season_number][$episode->episode_number]['Naam'] = $episode->episode_name;
                if (!empty($episode->overview)) {
                    $episodes[$episode->season_number][$episode->episode_number]['Naam'] = $episode->episode_name . "[img link=0 align=right title=\"" . $episode->overview . "\"]http://icon.ultimation.nl/information.png[/img]";
                }
                $episodes[$episode->season_number][$episode->episode_number]['Datum'] = $episode->first_aired;
                $episodes[$episode->season_number][$episode->episode_number]['Is uitgezonden?'] = $this->isBroadcastedIcon($episode->first_aired);

            }
        }

        //echo "<pre>";
        //print_r($this->_tvdb->episodes);
        //print_r($episodes);
        //echo "</pre>";
        //die();

        return $episodes;
    }

    /**
     * @param $broadcastDate
     *
     * @return string
     */
    private function isBroadcastedIcon($broadcastDate)
    {
        if (strlen($broadcastDate) > 0) {
            if ($this->episodeBroadcasted($broadcastDate)) {
                return ICON_URL . 'accept.png';
            }
        }
        return ICON_URL . 'cancel.png';
    }

    /**
     * Checks if a date is in the past
     *
     * @param $broadcastDate
     *
     * @return bool
     */
    private function episodeBroadcasted($broadcastDate)
    {
        return ((strtotime($broadcastDate) < time()));
    }
}