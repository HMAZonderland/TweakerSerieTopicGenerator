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
require_once dirname(__FILE__) . '/TweakersLib/TweakersUBB.php';
require_once dirname(__FILE__) . '/IMDbApiLib/IMDb.php';

if (isset($_GET['tvDbId']) && strlen($_GET['tvDbId']) > 0) {

    $tvdbApi = new TVDb();
    $tvdb = $tvdbApi->get_tv_show_by_id($_GET['tvDbId']);

    $tweakers = new TweakersUBB();
    $ubb = "";

    $imdb = new IMDbApi();
    $imdb->getSerieById($show->IMDB_id);

    if (isset($tvdb->name) && !empty($tvdb->name)) {

        $genres = null;
        foreach ($tvdb->genre as $genre) {
            $genres .= $genre . ",";
        }

        $plot = $show->overview;
        if (strlen($imdb->getSeriePlot()) > strlen($plot)) {
            $plot = $imdb->getSeriePlot();
        }

        $genres = substr($genres, 0, strlen($genres) - 1);

       echo $tweakers->getSerieHeader($tvdb->banner, $tvdb->name, $plot);
       echo "<br />";
       echo $tweakers->getSerieData($genres, $tvdb->first_aired, $tvdb->network, $tvdb->rating, $tvdb->status);
       echo "<br />";
       echo $tweakers->getActorTable($show->actors);

    } else {
        echo 'Invalide tvDbId. Geen serie gevonden.';
    }
} else {
    echo "Geen tvDbId ingevuld.";
}