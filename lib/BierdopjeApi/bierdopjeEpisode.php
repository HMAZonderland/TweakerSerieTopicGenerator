<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 10-07-13
 * Time: 13:48
 * To change this template use File | Settings | File Templates.
 */

class bierdopjeEpisode
{
    /**
     * @var int
     */
    public $episodeid;

    /**
     * @var int
     */
    public $tvdbid;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $showlink;

    /**
     * @var string
     */
    public $episodelink;

    /**
     * @var int
     */
    public $season;

    /**
     * @var int
     */
    public $episode;

    /**
     * @var int
     */
    public $epnumber;

    /**
     * @var bool
     */
    public $wip;

    /**
     * @var int
     */
    public $wippercentage;

    /**
     * @var string
     */
    public $wipuser;

    /**
     * @var float
     */
    public $score;

    /**
     * @var int
     */
    public $votes;

    /**
     * @var string
     */
    public $airdate;

    /**
     * @var string
     */
    public $formatted;

    /**
     * @var bool
     */
    public $is_special;

    /**
     * @var bool
     */
    public $subsnl;

    /**
     * @var bool
     */
    public $subsen;

    /**
     * @var string
     */
    public $updated;

    /**
     * @var array
     */
    public $summary;

    /**
     * @param SimpleXMLElement $data
     */
    public function __construct(SimpleXMLElement $data)
    {
        if ($data != null)
        {
            $this->episodeid        = (int) $data->episodeid;
            $this->tvdbid           = (int) $data->tvdbid;
            $this->title            = (string) $data->title;
            $this->showlink         = (string) $data->showlink;
            $this->episodelink      = (string) $data->episodelink;
            $this->season           = (int) $data->season;
            $this->episode          = (int) $data->episode;
            $this->epnumber         = (int) $data->epnumber;
            $this->wip              = (string)$data->wip;
            $this->wippercentage    = (int) $data->wippercentage;
            $this->wipuser          = (string) $data->wipuser;
            $this->score            = (string) $data->score;
            $this->votes            = (int) $data->votes;
            $this->airdate          = (string) $data->airdate;
            $this->formatted        = (string) $data->formatted;
            $this->is_special       = (string)$data->is_special;
            $this->subsnl           = (string)$data->subsnl;
            $this->subsen           = (string)$data->subsen;
            $this->updated          = (string) $data->updated;
            $this->summary          = preg_split("/\|/", $data->summary, -1, PREG_SPLIT_NO_EMPTY);
        }
    }
}