<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 08-07-13
 * Time: 11:00
 * To change this template use File | Settings | File Templates.
 */

class bierdopjeShow
{
    /**
     * @var int
     */
    public $showid;

    /**
     * @var int
     */
    public $tvdbid;

    /**
     * @var string
     */
    public $showname;

    /**
     * @var string
     */
    public $showlink;

    /**
     * @var string
     */
    public $firstaired;

    /**
     * @var string
     */
    public $lastaired;

    /**
     * @var string
     */
    public $nextepisode;

    /**
     * @var int
     */
    public $seasons;

    /**
     * @var int
     */
    public $episodes;

    /**
     * @var array
     */
    public $genres = array();

    /**
     * @var string
     */
    public $showstatus;

    /**
     * @var array
     */
    public $network;

    /**
     * @var string
     */
    public $airtime;

    /**
     * @var int
     */
    public $runtime;

    /**
     * @var float
     */
    public $score;

    /**
     * @var
     */
    public $favorites;

    /**
     * @var
     */
    public $has_translators;

    /**
     * @var
     */
    public $updated;

    /**
     * @var
     */
    public $summary;

    /**
     * @var
     */
    public $status;

    /**
     * @var
     */
    public $cached;

    /**
     * @var
     */
    public $apiversion;

    /**
     * @var
     */
    public $shows;

    /**
     * @param SimpleXMLElement $data
     */
    public function __construct(SimpleXMLElement $data)
    {
        if ($data != null)
        {
            $this->showid           = (int) $data->showid;
            $this->tvdbid           = (int) $data->tvdbid;
            $this->showname         = (string) $data->showname;
            $this->showlink         = (string) $data->showlink;
            $this->firstaired       = (string) $data->firstaired;
            $this->lastaired        = (string) $data->lastaired;
            $this->nextepisode      = (string) $data->nextepisode;
            $this->seasons          = (int) $data->seasons;
            $this->episodes         = (int) $data->episodes;
            $this->genres           = preg_split("/\|/", $data->genres, -1, PREG_SPLIT_NO_EMPTY);
            $this->showstatus       = (string) $data->showstatus;
            $this->network          = preg_split("/\|/", $data->network, -1, PREG_SPLIT_NO_EMPTY);
            $this->airtime          = (string) $data->airtime;
            $this->runtime          = (int) $data->runtime;
            $this->score            = (string) $data->score;
            $this->favorites        = (int) $data->favorites;
            $this->has_translators  = (string) $data->has_translators;
            $this->updated          = (string) $data->updated;
            $this->summary          = preg_split("/\|/", $data->summary, -1, PREG_SPLIT_NO_EMPTY);
            $this->status           = (string) $data->status;
            $this->cached           = (string) $data->cached;
            $this->apiversion       = (string) $data->apiversion;
        }
    }

    /**
     * @param SimpleXMLElement $data
     */
    public function setShows(SimpleXMLElement $data)
    {
        if ($data != null)
        {
            $tmp = array();
            foreach ($data->result as $ep)
            {
                if ($ep->season != 0)
                    array_push($tmp, new bierdopjeEpisode($ep));
            }
        }
        $this->shows = $tmp;
    }
}