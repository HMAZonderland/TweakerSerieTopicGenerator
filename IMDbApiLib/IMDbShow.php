<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 09-05-13
 * Time: 22:54
 * To change this template use File | Settings | File Templates.
 */

class IMDbShow {

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
        /*echo "<pre>";
        print_r($data);
        echo "</pre>";*/

        if ($data != null) {
            $this->imdb_id                  =       $data->imdb_id;
            $this->imdb_url                 =       $data->imdb_url;
            $this->title                    =       $data->title;
            $this->plot                     =       $data->plot;
            $this->plot_simple              =       $data->plot_simple;
            $this->rating                   =       $data->rating;
            $this->rating_count             =       $data->rating_count;
            $this->year                     =       $data->year;
            $this->genres                   =       (array) $data->genres->item;
            $this->rated                    =       $data->rated;
            $this->episodes                 =       $data->episodes;
            $this->actors                   =       $data->actors;
            $this->type                     =       $data->type;
            $this->poster                   =       $data->poster;
            $this->language                 =       $data->language;
            $this->country                  =       $data->country;
            $this->aspect_ratio             =       $data->technical->aspect_ratio->item;
            $this->cinematographic_process  =       $data->technical->cinematographic_process->item;
            $this->camera                   =       $data->technical->camera->item;
            $this->printed_film_format      =       $data->technical->printed_film_format->item;
            $this->film_negative_format     =       $data->technical->film_negative_format->item;
            $this->filming_locations        =       $data->filming_locations;
            $this->runtime                  =       $data->runtime->item;
            $this->laboratory               =       $data->technical->laboratory->item;
        }
    }
}