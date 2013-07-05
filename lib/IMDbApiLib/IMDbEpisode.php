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

    /**
     * @param SimpleXMLElement $data
     */
    public function __construct(array $data = null)
    {
        if ($data != null) {
            foreach ($data as $field => $value)
            $this->$field = $value;
        }
    }
}