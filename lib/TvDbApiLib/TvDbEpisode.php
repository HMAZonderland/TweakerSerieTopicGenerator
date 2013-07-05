<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 08-05-13
 * Time: 10:28
 * To change this template use File | Settings | File Templates.
 */

class TVDbEpisode
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $combined_episodenumber;

    /**
     * @var string
     */
    public $combined_season;

    /**
     * @var string
     */
    public $DVD_chapter;

    /**
     * @var string
     */
    public $DVD_discid;

    /**
     * @var string
     */
    public $DVD_episodenumber;

    /**
     * @var string
     */
    public $DVD_season;

    /**
     * @var array
     */
    public $directors = array();

    /**
     * @var string
     */
    public $episode_name;

    /**
     * @var string
     */
    public $episode_number;

    /**
     * @var string
     */
    public $first_aired;

    /**
     * @var array
     */
    public $guest_stars = array();

    /**
     * @var string
     */
    public $IMDB_id;

    /**
     * @var string
     */
    public $language;

    /**
     * @var string
     */
    public $overview;

    /**
     * @var string
     */
    public $production_code;

    /**
     * @var string
     */
    public $rating;

    /**
     * @var string
     */
    public $rating_count;

    /**
     * @var string
     */
    public $season_number;

    /**
     * @var array
     */
    public $writers = array();

    /**
     * @var string
     */
    public $absolute_number;

    /**
     * @var string
     */
    public $airsafter_season;

    /**
     * @var string
     */
    public $airsbefore_episode;

    /**
     * @var string
     */
    public $airsbefore_season;

    /**
     * @var string
     */
    public $lastupdated;

    /**
     * @var string
     */
    public $seasonid;

    /**
     * @var string
     */
    public $seriesid;

    /**
     * @param SimpleXMLElement $data SimpleXMLElement containing all the TV Show data
     */
    public function  __construct(SimpleXMLElement $data = null)
    {
        if ($data !== null) {
            $this->id = (int)$data->id;
            $this->combined_episodenumber = (string)$data->Combined_episodenumber;
            $this->combined_season = (string)$data->Combined_season;
            $this->DVD_chapter = (string)$data->DVD_chapter;
            $this->DVD_discid = (string)$data->DVD_discid;
            $this->DVD_episodenumber = (string)$data->DVD_episodenumber;
            $this->DVD_season = (string)$data->DVD_season;
            $this->directors = preg_split("/\|/", $data->Director, -1, PREG_SPLIT_NO_EMPTY);
            $this->episode_name = (string)$data->EpisodeName;
            $this->episode_number = (string)$data->EpisodeNumber;
            $this->first_aired = (string)$data->FirstAired;
            $this->guest_stars = preg_split("/\|/", $data->GuestStars, -1, PREG_SPLIT_NO_EMPTY);
            $this->IMDB_id = (string)$data->IMDB_ID;
            $this->language = (string)$data->Language;
            $this->overview = (string)$data->Overview;
            $this->production_code = (string)$data->ProductionCode;
            $this->rating = (string)$data->Rating;
            $this->rating_count = (string)$data->RatingCount;
            $this->season_number = (string)$data->SeasonNumber;
            $this->writers = preg_split("/\|/", $data->Writer, -1, PREG_SPLIT_NO_EMPTY);
            $this->absolute_number = (string)$data->absolute_number;
            $this->airsafter_season = (string)$data->airsafter_season;
            $this->airsbefore_episode = (string)$data->airsbefore_episode;
            $this->airsbefore_season = (string)$data->airsbefore_season;
            $this->lastupdated = (string)$data->lastupdated;
            $this->seasonid = (string)$data->seasonid;
            $this->seriesid = (string)$data->seriesid;
        }
    }
}