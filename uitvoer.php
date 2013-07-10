
<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 06-05-13
 * Time: 10:55
 * To change this template use File | Settings | File Templates.
 */
error_reporting(-1);

// Includes
require_once dirname(__FILE__) . '/config.php';

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Tweakers.net Serie Topic Generator</title>
</head>
<body>
<?php

if (isset($_GET['tvDbId']) && strlen($_GET['tvDbId']) > 0) {

    // Colors
    $borderColor = $_GET['borderColor'];
    $tableBgColor = $_GET['tableBgColor'];
    $tdBgColor = $_GET['tdBgColor'];
    $thBgColor = $_GET['thBgColor'];

    // All Serie data IMDb & TvDb combinend
    $serie = TweakersSerie::getSerieByTvDbId($_GET['tvDbId']);

    // UBB class
    $tweakers = new TweakersUBB($borderColor, $tableBgColor, $tdBgColor, $thBgColor);

    if (strlen($serie->getName()) > 0) {

        echo $tweakers->getSerieHeader($serie->getBanner(), $serie->getName(), $serie->getLongestPlot());
        echo "<br />";
        echo $tweakers->getSummery($serie->getEpisodesData());
        echo "<br />";
        echo $tweakers->getDataBlock("Algemene informatie", $serie->getGeneralInformation());
        echo "<br />";
        echo $tweakers->getDataBlock("Technische informatie", $serie->getTechnicalInformation());
        echo "<br />";
        echo $tweakers->getActorTable($serie->getActors());
        echo "<br />";
        echo $tweakers->getLinksTable($serie->getTvDbUrl(), $serie->getIMDbUrl(), $serie->getTraktUrl(), $serie->getBierdopjeUrl());
        echo "<br />";
        echo $tweakers->getEpisodesIndex($serie->getEpisodesData());

    } else {
        echo 'Invalide tvDbId. Geen serie gevonden.';
    }
} else {
    echo "Geen tvDbId ingevuld.";
}