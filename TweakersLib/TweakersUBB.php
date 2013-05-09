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
     * @param $ubbTable
     * @return string
     */
    private function getTable($ubbTable)
    {
        return "[table border=1 width=640 cellpadding=2 bordercolor=#" . $this->tableBorderColor . " bgcolor=#" . $this->tableBgColor . "]" . $ubbTable . "[/table]";
    }

    /**
     * Creates a serie topic header containing a banner
     * @param $bannerUrl
     * @param $title
     * @param $plot
     * @return string
     */
    public function getSerieHeader($bannerUrl, $title, $plot)
    {

        $str = "[tr]";
        $str .= "[td bgcolor=#" . $this->tdBgColor . "][img title='" . $title . "']" . $bannerUrl . "[/img][/td]";
        $str .= "[/tr]";
        $str .= "[tr]";
        $str .= "[th bgcolor=#" . $this->thBgColor . "]" . $title . "[/th]";
        $str .= "[/tr]";
        $str .= "[tr]";
        $str .= "[td bgcolor=#" . $this->tdBgColor . "]" . $plot . "[/td]";
        $str .= "[/tr]";

        return $this->getTable($str);
    }

    /**
     * Processes all sorts of general information
     * @param $genre
     * @param $first_aired
     * @param $network
     * @param $rating
     * @param $status
     * @return string
     */
    public function getSerieData($genre, $first_aired, $network, $rating, $status)
    {
        $str = "[tr]";
        $str .= "[th colspan=2 bgcolor=#" . $this->thBgColor . "]Algemene informatie[/th]";
        $str .= "[/tr]";
        $str .= "[tr]";
        $str .= "[td bgcolor=#" . $this->tdBgColor . "]Zender/Uitgever[/td]";
        $str .= "[td bgcolor=#" . $this->tdBgColor . "]" . $network . "[/td]";
        $str .= "[/tr]";
        $str .= "[tr]";
        $str .= "[td bgcolor=#" . $this->tdBgColor . "]Genre[/td]";
        $str .= "[td bgcolor=#" . $this->tdBgColor . "]" . $genre . "[/td]";
        $str .= "[/tr]";
        $str .= "[tr]";
        $str .= "[td bgcolor=#" . $this->tdBgColor . "]Eerste uitzending[/td]";
        $str .= "[td bgcolor=#" . $this->tdBgColor . "]" . $first_aired . "[/td]";
        $str .= "[/tr]";
        $str .= "[tr]";
        $str .= "[td bgcolor=#" . $this->tdBgColor . "]Cijfer[/td]";
        $str .= "[td bgcolor=#" . $this->tdBgColor . "]" . $rating . "[/td]";
        $str .= "[/tr]";
        $str .= "[tr]";
        $str .= "[td bgcolor=#" . $this->tdBgColor . "]Status[/td]";
        $str .= "[td bgcolor=#" . $this->tdBgColor . "]" . $status . "[/td]";
        $str .= "[/tr]";

        return $this->getTable($str);
    }

    /**
     * Rerturns a table containing all the actors
     * @param array $actors
     */
    public function getActorTable(SimpleXMLElement $actors)
    {

        $str = "[tr]";
        $str .= "[th colspan=2 bgcolor=#" . $this->thBgColor . "]Acteurs[/th]";
        $str .= "[/tr]";

        foreach ($actors as $actor) {
            $str .= "[tr]";
            $str .= "[td bgcolor=#" . $this->tdBgColor . " width=1][img title='" . $actor->Role . "']" . $actor->Image . "[/img][/td]";
            $str .= "[td bgcolor=#" . $this->tdBgColor . " valign=top]" . $actor->Role . " gespeeld door " . $actor->Name . "[/td]";
            $str .= "[/tr]";
        }

        return $this->getTable($str);
    }
}