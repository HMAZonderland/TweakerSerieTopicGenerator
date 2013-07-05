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
     * Trakt show var
     * @var
     */
    private $_trakt;

    /**
     * Sets up the object
     *
     * @param TvDbShow $tvdb
     * @param IMDbShow $imdb
     */
    public function __construct(TvDbShow $tvdb, IMDbShow $imdb, traktShow $trakt)
    {
        $this->_tvdb = $tvdb;
        $this->_imdb = $imdb;
        $this->_trakt = $trakt;
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
        $trakt = new Trakt(TRAKT_API_KEY);

        $tvdbShow = $tvdb->get_tv_show_by_id($tvdbId);
        $imDbShow = $imdb->getSerieById($tvdbShow->IMDB_id);
        $traktShow = new traktShow($trakt->showSummary($tvdbId, 'extend'));

       // Debug::p($traktShow);
      //  die();

        return new TweakersSerie($tvdbShow, $imDbShow, $traktShow);
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
     * @return country
     */
    public function getCountry()
    {
        return $this->_trakt->country;
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
        $traktRatings = $this->_trakt->ratings['percentage'];
        $traktVotes = $this->_trakt->ratings['votes'];
        $traktViewers = $this->_trakt->stats['watchers'];
        $traktPlays = $this->_trakt->stats['plays'];
        $status = $this->_tvdb->status;
        $network = $this->_tvdb->network;
        $first_air_date = $this->_tvdb->first_aired;
        $filming_locations = $this->_imdb->filming_locations;
        $runtime = $this->getRuntime();
        $languages = $this->getLanguagesAsString();
        $country = $this->getCountry();

        $array = array();

        if (strlen($network) > 0) $array['Uitgever'] = $network;
        if (strlen($genres) > 0) $array['Genre'] = $genres;
        if (strlen($first_air_date) > 0) $array['Begonnen'] = $first_air_date;
        if (strlen($imdbRatings) > 0) $array['[img]http://serie.ultimation.nl/images/IMDB-logo.png[/img] IMDb cijfer'] = $imdbRatings . " (" . $imdbVotes . " stemmen)";
        if (strlen($tvdbRatings) > 0) $array['[img]http://serie.ultimation.nl/images/tvdb_icon.png[/img] TvDb cijfer'] = $tvdbRatings . " (" . $tvdbVotes . " stemmen)";
        if (strlen($traktRatings) > 0) $array['[img]http://serie.ultimation.nl/images/trakt.gif[/img] Trakt percentage'] = $traktRatings . "% (" . $traktVotes . " stemmen)";
        if (strlen($traktViewers) > 0) $array['[img]http://serie.ultimation.nl/images/trakt.gif[/img] Kijkers op trakt'] = $traktViewers . " die gezamelijk " . $traktPlays . "x gekeken hebben";
        if (strlen($status) > 0) $array['Status'] = $status;
        if (strlen($filming_locations) > 0) $array['Film locaties'] = $filming_locations;
        if (strlen($runtime) > 0) $array['Speeltijd'] = $runtime;
        if (strlen($languages) > 0) $array['Uitgebracht in talen'] = $languages;
        if (strlen($country) > 0) $array['Land(en)'] = $country;

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
        $imdbGenres = $this->_imdb->genres;

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
     * Returns the runtime of an episode
     * @return mixed
     */
    private function getRuntime()
    {
        return ArrayToString::getStringLineBreak($this->_imdb->runtime);
    }

    /**
     * Returns all languages this serie is brought out with
     * @return string
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
        $array = array();

        foreach ($this->_imdb->technical as $field => $value) {
            $field = str_replace("_", " ", $field);
            $field = ucfirst($field);
            $array[$field] = ArrayToString::getStringLineBreak($value);
        }

        return $array;
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

        // reverse the trakt array
        $trakt_data = array_reverse($this->_trakt->seasons);
       // Debug::p($trakt_data);

        //Debug::p($this->_tvdb->episodes);
        //Debug::p($this->_trakt->seasons);

        // I know the TvDb offers more detailed information about the episode than IMDb does, so we go for that array.
        foreach ($this->_tvdb->episodes as $episode) {
            // No need for the specials
            if ($episode->season_number > 0) {

                // extract the trakt data
                $trakt_ep = $episode->episode_number - 1;
                $trakt_se = $episode->season_number - 1;
                $trakt_ratings = $trakt_data[$trakt_se]['episodes'][$trakt_ep]['ratings'];

                //Debug::s('trakt: ' . $trakt_se . ' ' . $trakt_ep);
                //Debug::s('tvdb: ' . $episode->season_number . ' ' . $episode->episode_number);

                //Debug::p($trakt_ratings);

                $episodes[$episode->season_number][$episode->episode_number]['S'] = $episode->season_number;
                $episodes[$episode->season_number][$episode->episode_number]['EP'] = $episode->episode_number;
                $episodes[$episode->season_number][$episode->episode_number]['Naam'] = $episode->episode_name;
                if (!empty($episode->overview)) {
                    $episodes[$episode->season_number][$episode->episode_number]['Naam'] = $episode->episode_name . "[img link=0 align=right title=\"" . $episode->overview . "\"]http://icon.ultimation.nl/information.png[/img]";
                }
                $episodes[$episode->season_number][$episode->episode_number]['Datum'] = $episode->first_aired;
                $episodes[$episode->season_number][$episode->episode_number]['Tv?'] = "[img link=0 ]" . $this->isBroadcastedIcon($episode->first_aired) . "[/img]";
                $episodes[$episode->season_number][$episode->episode_number]['[img]http://serie.ultimation.nl/images/trakt.gif[/img] rating'] = $trakt_ratings['percentage'] . "% " . $trakt_ratings['votes'] . " stemmen";
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

    /**
     * @return string
     */
    public function getTvDbUrl()
    {
        return $this->_tvdb->tvdb_url;
    }

    /**
     * @return mixed
     */
    public function getIMDbUrl()
    {
        return $this->_imdb->imdb_url;
    }

    /**
     * @return show
     */
    public function getTraktUrl()
    {
        return $this->_trakt->url;
    }
}