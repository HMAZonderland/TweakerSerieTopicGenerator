<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 16-05-13
 * Time: 21:00
 * To change this template use File | Settings | File Templates.
 */

class IMDbEpisode
{

    /**
     * Season number
     * @var
     */
    public $season;

    /**
     * Episode number
     * @var
     */
    public $episode;

    /**
     * Episode title
     * @var
     */
    public $title;

    public function __construct(SimpleXMLElement $data = null)
    {
        if ($data != null) {
            $this->title = (string)$data->title;
            $this->season = (int)$data->season;
            $this->episode = (int)$data->episode;
        }
    }
}