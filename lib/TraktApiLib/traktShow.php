<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 03-07-13
 * Time: 11:51
 * To change this template use File | Settings | File Templates.
 */

class traktShow
{
    /**
     * @var show title
     */
    public $title;

    /**
     * @var show year
     */
    public $year;

    /**
     * @var show trakt URL
     */
    public $url;

    /**
     * @var first aired timestamp
     */
    public $first_aired;

    /**
     * @var first aired iso
     */
    public $first_aired_iso;

    /**
     * @var first aired utc timestamp
     */
    public $first_aired_utc;

    /**
     * @var country
     */
    public $country;

    /**
     * @var short summeray
     */
    public $overview;

    /**
     * @var episode runtime
     */
    public $runtime;

    /**
     * @var publishing network
     */
    public $network;

    /**
     * @var air date
     */
    public $air_day;

    /**
     * @var air date utc timestamp
     */
    public $air_day_utc;

    /**
     * @var air time
     */
    public $air_time;

    /**
     * @var air time utc timestamp
     */
    public $air_time_utc;

    /**
     * @var certification
     */
    public $certification;

    /**
     * @var tvshow IMDB id
     */
    public $imdb_id;

    /**
     * @var tvshow TvDB id
     */
    public $tvdb_id;

    /**
     * @var tvshow TvRage id
     */
    public $tvrage_id;

    /**
     * @var last time updated
     */
    public $last_updated;

    /**
     * @var array URL's to images
     */
    public $images = array();

    /**
     * @var array containing data about top watchers of this show at trakt
     */
    public $top_watchers = array();

    /**
     * @var array containing data about best viewed episodes of this show
     */
    public $top_episodes = array();

    /**
     * @var array trakt user ratings
     */
    public $ratings = array();

    /**
     * @var array trakt user statistics
     */
    public $stats = array();

    /**
     * @var actor data
     */
    public $people = array();

    /**
     * @var array genre's
     */
    public $genres = array();

    /**
     * @var array episode index
     */
    public $seasons = array();

    /**
     * @param array $jsondata data
     *
     */
    public function __construct($jsondata = array())
    {
        foreach ($jsondata as $field => $value) {
            $this->$field = $value;
        }

        // Remove the specials..
        $tmp = array();
        foreach ($this->seasons as $season) {
            if ($season['season'] != 0)  {
                array_push($tmp, $season);
            }
        }
        $this->seasons = $tmp;
    }
}