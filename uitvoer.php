<?php
require_once dirname(__FILE__) . '/TVDb-API-Class/TVDb.php';
require_once dirname(__FILE__) . '/Tweakers/TweakersUBB.php';

/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 06-05-13
 * Time: 10:55
 * To change this template use File | Settings | File Templates.
 */

if (isset($_GET['tvDbId']) && strlen($_GET['tvDbId']) > 0) {

    $tvdb = new TVDb();
    $show = $tvdb->get_tv_show_by_id($_GET['tvDbId']);

    $tweakers = new TweakersUBB();
    $ubb = "";

    if (isset($show->name) && !empty($show->name)) {

        $genres;
        foreach ($show->genre as $genre) {
            $genres .= $genre . ",";
        }

        $genres = substr($genres, 0, strlen($genres) - 1);

       echo $tweakers->getSerieHeader($show->banner, $show->name, $show->overview);
       echo "<br />";
       echo $tweakers->getSerieData($genres, $show->first_aired, $show->network, $show->rating, $show->status);

    } else {
        echo 'Invalide tvDbId. Geen serie gevonden.';
    }
} else {
    echo "Geen tvDbId ingevuld.";
}