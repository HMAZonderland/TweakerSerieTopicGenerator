<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 06-05-13
 * Time: 10:55
 * To change this template use File | Settings | File Templates.
 */
error_reporting(-1);

require_once dirname(__FILE__) . '/tools/C_URL.tool.php';
require_once dirname(__FILE__) . '/tools/SimpleXML.tool.php';

require_once dirname(__FILE__) . '/TvDbApiLib/TVDb.php';
require_once dirname(__FILE__) . '/TvDbApiLib/TvDbShow.php';
require_once dirname(__FILE__) . '/TvDbApiLib/TvDbEpisode.php';
require_once dirname(__FILE__) . '/SimpleImageLib/SimpleImage.class.php';
require_once dirname(__FILE__) . '/IMDbApiLib/IMDb.php';
require_once dirname(__FILE__) . '/IMDbApiLib/IMDbShow.php';
require_once dirname(__FILE__) . '/TweakersLib/TweakersUBB.php';
require_once dirname(__FILE__) . '/TweakersLib/TweakersSerie.php';

if (isset($_GET['tvDbId']) && strlen($_GET['tvDbId']) > 0) {

    $serie = TweakersSerie::getSerieByTvDbId($_GET['tvDbId']);
    $tweakers = new TweakersUBB();

    if (strlen($serie->getName()) > 0) {

       echo $tweakers->getSerieHeader($serie->getBanner(), $serie->getName(), $serie->getLongestPlot());
       echo "<br /><br />";
       echo $tweakers->getSerieData($serie->getGenresAsString(), $serie->getFirstAirDate(), $serie->getNetwork(), $serie->getRatings(), $serie->getStatus());
       echo "<br /><br />";
       echo $tweakers->getActorTable($serie->getActors());
       echo "<br /><br />";
       echo $tweakers->getLinksTable($serie->getTvDbUrl(), $serie->getIMDbUrl());

    } else {
        echo 'Invalide tvDbId. Geen serie gevonden.';
    }
} else {
    echo "Geen tvDbId ingevuld.";
}