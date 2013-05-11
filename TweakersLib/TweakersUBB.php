<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 06-05-13
 * Time: 11:24
 * To change this template use File | Settings | File Templates.
 */

class TweakersUBB
{

    /**
     * Contains the table border color (outside border of the table)
     * @var string
     */
    public $tableBorderColor;

    /**
     * Contains the table background color
     * @var string
     */
    public $tableBgColor;

    /**
     * Contains a color used for all the td backgrounds
     * @var string
     */
    public $tdBgColor;

    /**
     * Contains the color used for the th background
     * @var
     */
    public $thBgColor;

    /**
     * Construct
     *
     * @param string $tableBorderColor
     * @param string $tableBgColor
     * @param string $tdBgColor
     */
    function __construct($tableBorderColor = "000", $tableBgColor = "000", $tdBgColor = "FFF", $thBgColor = "000")
    {
        $this->tableBorderColor = $tableBorderColor;
        $this->tableBgColor = $tableBgColor;
        $this->tdBgColor = $tdBgColor;
        $this->thBgColor = $thBgColor;
    }

    /**
     * Returns a table wraper
     *
     * @param $ubbTable
     *
     * @return string
     */
    private function getTable($ubbTable)
    {
        return "[table border=1 width=640 cellpadding=2 bordercolor=#" . $this->tableBorderColor . " bgcolor=#" . $this->tableBgColor . "]" . $ubbTable . "[/table]";
    }

    /**
     * Creates a td cell
     *
     * @param $cell
     *
     * @return string
     */
    private function getTd($cell)
    {
        $str = "[td bgcolor=#" . $this->tdBgColor . " ";
        foreach ($cell as $property => $value) {
            if ($property != 'data') {
                $str .= $property . "=" . $value;
            }
        }
        $str .= "]" . $cell['data'] . "[/td]";
        return $str;
    }

    /**
     * Creates a table cell
     * $var[]['data'] contains the inner part of the cell.
     * $var[]['other'] contains all the posible attributes
     *
     * To enable multiple cells create an array containing the cells
     *
     * @param array $cells
     * @param int   $colspan
     *
     * @return string
     */
    private function getTdRow(array $cells)
    {
        $str = "[tr]";
        foreach ($cells as $cell) {
            $str .= $this->getTd($cell);
        }
        $str .= "[/tr]";
        return $str;
    }

    /**
     * Creates a table header
     * $var['data'] contains the inner part of the cell.
     * $var['other'] contains all the posible attributes
     *
     * @param     $cell
     * @param int $colspan
     *
     * @return string
     */
    private function getThRow(array $cell)
    {
        $str = "[tr]";
        $str .= "[th bgcolor=#" . $this->thBgColor . " ";
        foreach ($cell as $property => $value) {
            if ($property != 'data') {
                $str .= $property . "=" . $value;
            }
        }
        $str .= "]" . $cell['data'] . "[/th][/tr]";
        return $str;
    }

    /**
     * Creates a TD array object.
     * $var['data'] contains the inner part of the cell.
     * $var['other'] contains all the posible attributes
     *
     * @param       $data
     * @param array $attributes
     *
     * @return array
     */
    private static function createDataArray($data, array $attributes = null)
    {
        $array = array();
        $array['data'] = $data;
        if ($attributes != null) {
            foreach ($attributes as $attribute => $value) {
                $array[$attribute] = $value;
            }
        }
        return $array;
    }

    /**
     * Creates a serie topic header containing a banner
     *
     * @param $bannerUrl
     * @param $title
     * @param $plot
     *
     * @return string
     */
    public function getSerieHeader($bannerUrl, $title, $plot)
    {
        $str = $this->getTdRow(array(self::createDataArray("[img title='" . $title . "']" . $bannerUrl . "[/img]")));
        $str .= $this->getThRow(self::createDataArray($title));
        $str .= $this->getTdRow(array(self::createDataArray($plot)));

        return $this->getTable($str);
    }

    /**
     * Processes all sorts of general information
     *
     * @param array $generaldata
     *
     * @return string
     */
    public function getGeneralData(array $generaldata)
    {
        $str = $this->getThRow(self::createDataArray("Algemene informatie", array("colspan" => 2)));
        foreach ($generaldata as $data => $var) {
            $str .= $this->getTdRow(array(self::createDataArray($data), self::createDataArray($var)));
        }

        return $this->getTable($str);
    }

    /**
     * Returns a table containing all the actors
     *
     * @param array $actors
     */
    public function getActorTable(SimpleXMLElement $actors)
    {
        $str = $this->getThRow(self::createDataArray("Acteurs", array("colspan" => 2)));
        foreach ($actors as $actor) {

            if (strlen($actor->Image) > 0) {
                $left = self::createDataArray("[img title='" . $actor->Role . "']" . $actor->Image . "[/img]", array("width" => 1));
                $right = self::createDataArray($actor->Role . " gespeeld door " . $actor->Name, array("valign" => "top"));
                $cells = array($left, $right);
                $str .= $this->getTdRow($cells);
            }  else {
                $str .= $this->getTdRow(array(self::createDataArray($actor->Role . " gespeeld door " . $actor->Name)));
            }
        }
        return $this->getTable($str);
    }

    /**
     * Creates a table containing links to all sorts of resources related to the serie
     *
     * @param $imdb
     * @param $tvdb
     *
     * @return string
     */
    public function getLinksTable($tvdbUrl, $imdbUrl)
    {
        $str  = $this->getThRow(self::createDataArray("Links", array("colspan" => 2)));
        $str .= $this->getTdRow(array(self::createDataArray("IMDb"), self::createDataArray($tvdbUrl)));
        $str .= $this->getTdRow(array(self::createDataArray("TvDb"), self::createDataArray($imdbUrl)));
        return $this->getTable($str);
    }
}