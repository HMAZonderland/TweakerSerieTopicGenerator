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
        $str = '';
        if (strlen($bannerUrl) > 0) $str .= $this->getTdRow(array(self::createDataArray("[img title='" . $title . "']" . $bannerUrl . "[/img]")));
        $str .= $this->getThRow(array(self::createDataArray($title)));
        if (strlen($plot) > 0) $str .= $this->getTdRow(array(self::createDataArray($plot)));

        return $this->getTable($str);
    }

    /**
     * Creates a table cell
     * $var[]['data'] contains the inner part of the cell.
     * $var[]['other'] contains all the posible attributes
     *
     * To enable multiple cells create an array containing the cells
     *
     * @param array $cells
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
     * Creates a td cell
     *
     * @param $cell
     *
     * @return string
     */
    private function getTd($cell)
    {
        return $this->getCell($cell, "td");
    }

    /**
     * Creates a cell, this could be td/th
     *
     * @param $cell containing cell data
     * @param $type th/td
     *
     * @return string
     */
    private function getCell($cell, $type)
    {
        $color = $this->tdBgColor;
        if ($type == "th") {
            $color = $this->thBgColor;
        }

        if ($this->tableBgColor != $this->tdBgColor && $type == "td") {
            $str = "[" . $type . " bgcolor=#" . $color . " ";
        } else if ($this->tableBgColor != $this->thBgColor && $type == "th") {
            $str = "[" . $type . " bgcolor=#" . $color . " ";
        } else {
            $str = "[" . $type . " ";
        }

        foreach ($cell as $property => $value) {
            if ($property != 'data') {
                $str .= $property . "=" . $value . " ";
            }
        }
        $str = substr($str, 0, strlen($str) - 1);
        $str .= "]" . $cell['data'] . "[/" . $type . "]";
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
     * Creates a table header
     * $var[]['data'] contains the inner part of the cell.
     * $var[]['other'] contains all the posible attributes
     *
     * @param    array $cells
     *
     * @return string
     */
    private function getThRow(array $cells)
    {
        $str = "[tr]";
        foreach ($cells as $cell) {
            $str .= $this->getTh($cell);
        }
        $str .= "[/tr]";
        return $str;
    }

    /**
     * @param $cell
     *
     * @return string
     */
    private function getTh($cell)
    {
        return $this->getCell($cell, "th");
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
     * Processes an array containing data.
     * Could be used for general- and technical information about the serie or links to website
     *
     * @param       $title
     * @param array $blockData
     *
     * @return string
     */
    public function getDataBlock($title, array $blockData)
    {
        $str = $this->getThRow(array(self::createDataArray($this->addAnchor($title), array("colspan" => 2))));
        foreach ($blockData as $data => $var) {
            $str .= $this->getTdRow(array(self::createDataArray($data, array("valign", "top")), self::createDataArray($var)));
        }
        $str .= $this->addBackToSummeryLink();
        return $this->getTable($str);
    }

    /**
     * Adds an anchor
     *
     * @param $text
     * @param $anchor
     *
     * @return string
     */
    private function addAnchor($text)
    {
        $label = str_replace(' ', '', $text);
        return "[anchor=an_" . $label . "]" . $text . "[/anchor]";
    }

    /**
     * @param int $cols
     *
     * @return string
     */
    private function addBackToSummeryLink($cols = 2)
    {
        return $this->getTdRow(array(self::createDataArray("[right]" . $this->addJump("Naar de inhoudsopgave", "Klik hier om terug te gaan naar de inhoudsopgave", "Inhoudsopgave") . "[/right]", array("colspan" => $cols, "bgcolor" => "#" . $this->thBgColor, "fontsize" => 9))));
    }

    /**
     * Enables linking to anchors
     *
     * @param $text
     * @param $label
     *
     * @return string
     */
    private function addJump($text, $tip, $label = null)
    {
        if ($label == null) $label = str_replace(' ', '', $text);
        return "[jump=an_" . $label . ", " . $tip . "] " . $text . " [/jump]";
    }

    /**
     * @param $seasons
     *
     * @return string
     */
    public function getSummery($seasons)
    {
        $seasons = sizeof($seasons) + 1;
        $str = $this->getThRow(array(self::createDataArray($this->addAnchor("Inhoudsopgave"))));
        $str .= $this->getTdRow(array(self::createDataArray($this->addJump("Algemene informatie", "Lees meer over algemene informatie."))));
        $str .= $this->getTdRow(array(self::createDataArray($this->addJump("Technische informatie", "Lees meer over de technische aspecten van deze serie."))));
        $str .= $this->getTdRow(array(self::createDataArray($this->addJump("Acteurs", "Zie welke acteurs in deze serie spelen."))));
        $str .= $this->getTdRow(array(self::createDataArray($this->addJump("Links", "Diverse weblinks."))));
        $str .= $this->getTdRow(array(self::createDataArray($this->addJump("Afleveringen", "Bekijk de afleveringen"))));
        for ($i = 1; $i != $seasons; $i++) {
            $str .= $this->getTdRow(array(self::createDataArray($this->addJump("[img]http://icon.ultimation.nl/top_right.png[/img] Seizoen " . $i, "Bekijk de afleveringen van seizoen " . $i, $i))));
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
        $str = $this->getThRow(array(self::createDataArray($this->addAnchor("Acteurs"), array("colspan" => 2))));
        foreach ($actors as $actor) {
            // it might happen we do not have an actor image
            if (strlen($actor->Image) > 0 && is_object($actor->Image)) {
                $left = self::createDataArray("[img title=\"" . $actor->Role . "\"]" . $actor->Image . "[/img]", array("width" => 1));
                $right = self::createDataArray($actor->Role . " gespeeld door " . $actor->Name, array("valign" => "top"));
                $cells = array($left, $right);
                $str .= $this->getTdRow($cells);
            } else {
                if (strlen($actor->Name) > 0 && strlen($actor->Role) > 0) {
                    $str .= $this->getTdRow(array(self::createDataArray($actor->Role . ' gespeeld door ' . $actor->Name, array("colspan" => 2))));
                } else if (strlen($actor->Name) > 0) {
                    $str .= $this->getTdRow(array(self::createDataArray($actor->Name, array("colspan" => 2))));
                } else {
                    $str .= $this->getTdRow(array(self::createDataArray($actor->Role, array("colspan" => 2))));
                }

            }
        }
        $str .= $this->addBackToSummeryLink();
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
    public function getLinksTable($tvdbUrl, $imdbUrl, $traktUrl)
    {
        $str = $this->getThRow(array(self::createDataArray($this->addAnchor("Links"), array("colspan" => 2))));
        $str .= $this->getTdRow(array(self::createDataArray("IMDb"), self::createDataArray($imdbUrl)));
        $str .= $this->getTdRow(array(self::createDataArray("TvDb"), self::createDataArray($tvdbUrl)));
        $str .= $this->getTdRow(array(self::createDataArray("trakt"), self::createDataArray($traktUrl)));
        $str .= $this->addBackToSummeryLink();
        return $this->getTable($str);
    }

    /**
     * @param $episodes
     */
    public function getEpisodesIndex($seasons)
    {
        // [1][1] there is always a first episode of the first season
        $cols = sizeof($seasons[1][1]);
        $str = $this->getThRow(array(self::createDataArray($this->addAnchor("Afleveringen"), array("colspan" => $cols))));
        $str .= $this->getThRow(array(self::createDataArray("Hoover met de muis over het [img]http://icon.ultimation.nl/information.png[/img] icoon voor een omschrijving van de aflevering.", array("colspan" => $cols))));

        foreach ($seasons as $season) {
            $header = array();
            $rows = array();
            $doRowspan = true;
            foreach ($season as $episode) {
                $row = array();
                foreach ($episode as $var => $data) {
                    $head = self::createDataArray("[b]" . $var . "[/b]", array("width" => 5, "bgcolor" => "#" . $this->thBgColor));
                    if (!in_array($head, $header)) {
                        array_push($header, $head);
                    }

                    if ($var == 'Uitgezonden?') {
                        array_push($row, self::createDataArray("[img]" . $data . "[/img]", array("width" => 1, "valign" => "top")));
                    } elseif ($var == 'S' && $doRowspan) {
                        $doRowspan = false;
                        array_push($row, self::createDataArray($this->addAnchor($data), array("rowspan" => sizeof($season), "valign" => "top", "width" => 1)));
                    } elseif ($var != 'S') {
                        array_push($row, self::createDataArray($data, array("valign" => "top")));
                    }
                }
                array_push($rows, $this->getTdRow($row));
            }

            $str .= $this->getTdRow($header);
            foreach ($rows as $r) {
                $str .= $r;
            }


            // var is header
            //echo "<pre>";
            //print_r($rows);
            //print_r($str);
            //echo "</pre>";
            //die();

        }

        //echo "OUTPUT!<pre>";
        //print_r($str);
        //echo "</pre>";
        //die();
        $str .= $this->addBackToSummeryLink(6);
        return $this->getTable($str);
    }
}