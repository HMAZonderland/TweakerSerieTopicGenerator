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
    public $id;
    public $combined_episodenumber;
    public $combined_season;
    public $DVD_chapter;
    public $DVD_discid;
    public $DVD_episodenumber;
    public $DVD_season;
    public $directors = array();
    public $episode_name;
    public $episode_number;
    public $first_aired;
    public $guest_stars = array();
    public $IMDB_id;
    public $language;
    public $overview;
    public $production_code;
    public $rating;
    public $rating_count;
    public $season_number;
    public $writers = array();
    public $absolute_number;
    public $airsafter_season;
    public $airsbefore_episode;
    public $airsbefore_season;
    public $lastupdated;
    public $seasonid;
    public $seriesid;

    /**
     * @param SimpleXMLElement $data SimpleXMLElement containing all the TV Show data
     */
    public function  __construct(SimpleXMLElement $data=null)
    {
        if($data !== null) {
            $this->id                     = (int)$data->id;
            $this->combined_episodenumber = (string)$data->Combined_episodenumber;
            $this->combined_season        = (string)$data->Combined_season;
            $this->DVD_chapter            = (string)$data->DVD_chapter;
            $this->DVD_discid             = (string)$data->DVD_discid;
            $this->DVD_episodenumber      = (string)$data->DVD_episodenumber;
            $this->DVD_season             = (string)$data->DVD_season;
            $this->directors              = preg_split("/\|/", $data->Director, -1, PREG_SPLIT_NO_EMPTY);
            $this->episode_name           = (string)$data->EpisodeName;
            $this->episode_number         = (string)$data->EpisodeNumber;
            $this->first_aired            = (string)$data->FirstAired;
            $this->guest_stars            = preg_split("/\|/", $data->GuestStars, -1, PREG_SPLIT_NO_EMPTY);
            $this->IMDB_id                = (string)$data->IMDB_ID;
            $this->language               = (string)$data->Language;
            $this->overview               = (string)$data->Overview;
            $this->production_code        = (string)$data->ProductionCode;
            $this->rating                 = (string)$data->Rating;
            $this->rating_count           = (string)$data->RatingCount;
            $this->season_number          = (string)$data->SeasonNumber;
            $this->writers                = preg_split("/\|/", $data->Writer, -1, PREG_SPLIT_NO_EMPTY);
            $this->absolute_number        = (string)$data->absolute_number;
            $this->airsafter_season       = (string)$data->airsafter_season;
            $this->airsbefore_episode     = (string)$data->airsbefore_episode;
            $this->airsbefore_season      = (string)$data->airsbefore_season;
            $this->lastupdated            = (string)$data->lastupdated;
            $this->seasonid               = (string)$data->seasonid;
            $this->seriesid               = (string)$data->seriesid;
        }
    }
}