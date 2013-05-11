<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 08-05-13
 * Time: 10:27
 * To change this template use File | Settings | File Templates.
 */

class TVDbShow
{
    /**
     * Contains a list of TVDbEpisode objects.
     *
     * Only populated by the get_tv_show_by_id function.
     * @access public
     * @var array
     */
    public $episodes = array();

    /**
     * TVDb ID
     * @access public
     * @var int
     */
    public $id;

    /**
     * Array of actor names
     * @access public
     * @var array
     */
    public $actors = array();

    /**
     * Day on which TV show is shown
     * @access public
     * @var string
     */
    public $airs_day_of_week;

    /**
     * Time TV show is/was shown
     * @access public
     * @var string
     */
    public $airs_time;

    /**
     * Date TV show was first shown
     * @access public
     * @var string
     */
    public $first_aired;

    /**
     * Array of genres
     * @access public
     * @var array
     */
    public $genre = array();

    /**
     * IMDB id
     * @access public
     * @var string
     */
    public $IMDB_id;

    /**
     * Language this information is in
     *
     * Should be 'en', 'fr', ect.
     * @access public
     * @var string
     */
    public $language;

    /**
     * Network TV show is shown on
     * @access public
     * @var string
     */
    public $network;

    /**
     * TVDb network ID?
     * @access public
     * @var string
     */
    public $network_id;

    /**
     * Overview of the TV show
     * @access public
     * @var string
     */
    public $overview;

    /**
     * TVDb rating of the TV show
     * @access public
     * @var string
     */
    public $rating;

    /**
     * Number of ratings
     * @access public
     * @var string
     */
    public $rating_count;

    /**
     * The shows runttime
     * @access public
     * @var string
     */
    public $runtime;

    /**
     * zap2it ID
     * @access public
     * @var string
     */
    public $zap2it_id;

    /**
     * TV Shows name
     * @access public
     * @var string
     */
    public $name;

    /**
     * Status of the TV show. If it has ended, ect.
     * @access public
     * @var string
     */
    public $status;

    /**
     * Time stamp of when the TV show was last updated
     * @access public
     * @var string
     */
    public $last_updated;

    /**
     * Banner url file
     * @access public
     * @var string
     */
    public $banner;

    /**
     * @param SimpleXMLElement $data SimpleXMLElement containing all the TV Show data
     */
    public function  __construct(SimpleXMLElement $data=null)
    {
        if($data !== null) {
            $this->id               = (int)$data->id;
            $this->actors           = preg_split("/\|/", $data->Actors, -1, PREG_SPLIT_NO_EMPTY);
            $this->airs_day_of_week = (string)$data->Airs_DayOfWeek;
            $this->airs_time        = (string)$data->Airs_Time;
            $this->first_aired      = (string)$data->FirstAired;
            $this->genre            = preg_split("/\|/", $data->Genre, -1, PREG_SPLIT_NO_EMPTY);
            $this->IMDB_id          = (string)$data->IMDB_ID;
            $this->language         = (string)$data->language;
            $this->network          = (string)$data->Network;
            $this->network_id       = (string)$data->NetworkID;
            $this->overview         = (string)$data->Overview;
            $this->rating           = (string)$data->Rating;
            $this->rating_count     = (string)$data->RatingCount;
            $this->runtime          = (string)$data->Runtime;
            $this->zap2it_id        = (string)$data->zap2it_id;
            $this->name             = (string)$data->SeriesName;
            $this->status           = (string)$data->Status;
            $this->last_updated     = (string)$data->lastupdated;
            $this->tvdb_url         = 'http://thetvdb.com/?tab=series&id=' . $this->id;

            // Plaatje maken en cachen
            if (isset($data->banner) && strlen($data->banner) > 0) {
                if (!file_exists($data->banner)) {
                    // Might happen that the image does not exist
                    try {
                        $img = new SimpleImage();
                        $img->load('http://thetvdb.com/banners/' . $data->banner)->fit_to_width(640)->save($data->banner, 80);
                    } catch (Exception $e) {
                        //echo "Exception occured: " . $e->getMessage() . "<br />";
                        $this->banner = '';
                    }
                }
                $this->banner = 'http://ultimation.nl/tweakers/' . $data->banner;
            }
        }
    }

    //Plaatje maken
    public function setActors($actors) {
        if (isset($actors) && sizeof($actors) > 0) {
            foreach ($actors as $actor) {
                if (strlen($actor->Image) > 0) {
                    if (!file_exists($actor->Image)) {
                        // Might happen that the image does not exists
                        try {
                            $img = new SimpleImage();
                            $img->load('http://thetvdb.com/banners/' . $actor->Image)->best_fit(120, 150)->save($actor->Image, 80);
                        } catch (Exception $e) {
                            //echo "Exception occured: " . $e->getMessage() . "<br />";
                            $actor->Image = '';
                        }
                    }
                    $actor->Image = 'http://ultimation.nl/tweakers/' . $actor->Image;
                }
            }
        }
        $this->actors = $actors;
    }
}