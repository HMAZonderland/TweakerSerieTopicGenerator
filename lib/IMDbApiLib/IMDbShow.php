<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 09-05-13
 * Time: 22:54
 * To change this template use File | Settings | File Templates.
 */

class IMDbShow
{
    /**
     * Serie plot, long version
     * @var
     */
    public $plot;

    /**
     * Serie genre's
     * @var
     */
    public $genres;

    /**
     * Langauge
     * @var
     */
    public $language;

    /**
     * Contains various sub arrays and values, could be production and filming dates
     * @var
     */
    public $business;

    /**
     * Serie title
     * @var
     */
    public $title;

    /**
     * Contains various technical data, such as aspect ratio, camera info and negativ information
     * @var
     */
    public $technical;

    /**
     * Country/ies filmed
     * @var
     */
    public $country;

    /**
     * IMDb URL
     * @var
     */
    public $imdb_url;

    /**
     * @var
     */
    public $directors;

    /**
     * IMDb ID
     * @var
     */
    public $imdb_id;

    /**
     * Array of episodes
     * @var
     */
    public $episodes;

    /**
     * Serie writers
     * @var
     */
    public $writers;

    /***
     * Serie actors
     * @var
     */
    public $actors;

    /**
     * Short version plot
     * @var
     */
    public $plot_simple;

    /**
     * Year
     * @var
     */
    public $year;

    /**
     * Filming locations
     * @var
     */
    public $filming_locations;

    /**
     * Type of serie?
     * @var
     */
    public $type;

    /**
     * Release data/see year
     * @var
     */
    public $release_date;

    /**
     * Runtime per EP
     * @var
     */
    public $runtime;

    /**
     * IMDb Rating
     * @var
     */
    public $rating;

    /**
     * Serie poster image
     * @var
     */
    public $poster;

    /**
     * Number of votes
     * @var
     */
    public $rating_count;

    /**
     * When brought out in other langauges, names of those series here
     * @var
     */
    public $also_known_as;

    /**
     *
     */
    public function __construct($data = array())
    {
        if ($data != null) {
            foreach ($data as $field => $value) {
                $this->$field = $value;
            }
        }
        return $this;
    }
}