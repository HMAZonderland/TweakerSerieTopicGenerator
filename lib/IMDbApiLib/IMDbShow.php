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
     * IMDb Id of the serie
     * @var
     */
    public $imdb_id;

    /**
     * URL to the IMDb webpage
     * @var
     */
    public $imdb_url;

    /**
     * Title of the serie
     * @var
     */
    public $title;

    /**
     * Plot of the serie
     * @var
     */
    public $plot;

    /**
     * Short version of the serie plot
     * @var
     */
    public $plot_simple;

    /**
     * IMDb rating
     * @var
     */
    public $rating;

    /**
     * IMdb rating count, voting people
     * @var
     */
    public $rating_count;

    /**
     * Year released
     * @var
     */
    public $year;

    /**
     * Genres
     * @var
     */
    public $genres;

    /**
     * Rated
     * @var
     */
    public $rated;

    /**
     * Episodes
     * @var
     */
    public $episodes = array();

    /**
     * Actors playing
     * @var
     */
    public $actors = array();

    /**
     * Type of serie
     * @var
     */
    public $type;

    /**
     * Link to poster on IMDb
     * @var
     */
    public $poster;

    /**
     * Language spoken in serie
     * @var
     */
    public $language;

    /**
     * Country playing
     * @var
     */
    public $country = array();

    /**
     * Aspect ratio
     * @var
     */
    public $aspect_ratio = array();

    /**
     * Cinematographic process
     * @var
     */
    public $cinematographic_process = array();

    /**
     * Camera's used in recording
     * @var
     */
    public $camera = array();

    /**
     * Printed film format
     * @var
     */
    public $printed_film_format = array();

    /**
     * Negative format
     * @var
     */
    public $film_negative_format = array();

    /**
     * Filming locations
     * @var
     */
    public $filming_locations;

    /**
     * Runtime per episode
     * @var
     *
     */
    public $runtime;

    /**
     *
     */
    public function __construct(SimpleXMLElement $data = null)
    {
        if ($data != null) {
            $this->imdb_id = (string)$data->imdb_id;
            $this->imdb_url = (string)$data->imdb_url;
            $this->title = (string)$data->title;
            $this->plot = (string)$data->plot;
            $this->plot_simple = (string)$data->plot_simple;
            $this->rating = (double)$data->rating;
            $this->rating_count = (int)$data->rating_count;
            $this->year = (string)$data->year;
            $this->genres = (array)$data->genres;
            $this->rated = (string)$data->rated;
            //$this->episodes                 =       $data->episodes;
            $this->actors = (array)$data->actors;
            $this->type = (string)$data->type;
            $this->poster = (string)$data->poster;
            $this->language = (array)$data->language;
            $this->country = (array)$data->country;
            $this->aspect_ratio = (array)$data->technical->aspect_ratio;
            $this->cinematographic_process = (array)$data->technical->cinematographic_process;
            $this->camera = (array)$data->technical->camera;
            $this->printed_film_format = (array)$data->technical->printed_film_format;
            $this->film_negative_format = (array)$data->technical->film_negative_format;
            $this->filming_locations = (string)$data->filming_locations;
            $this->runtime = (string)$data->runtime->item;
            $this->laboratory = (string)$data->technical->laboratory;
        }

        return $this;
    }
}