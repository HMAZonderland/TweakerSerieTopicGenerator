<?php
ob_start();

require_once dirname(__FILE__) . '/tools/C_URL.tool.php';
require_once dirname(__FILE__) . '/tools/SimpleXML.tool.php';
require_once dirname(__FILE__) . '/TvDbApiLib/TVDb.php';
require_once dirname(__FILE__) . '/TvDbApiLib/TvDbShow.php';
require_once dirname(__FILE__) . '/TvDbApiLib/TvDbEpisode.php';
require_once dirname(__FILE__) . '/SimpleImageLib/SimpleImage.class.php';
require_once dirname(__FILE__) . '/TweakersLib/TweakersUBB.php';
require_once dirname(__FILE__) . '/IMDbApiLib/IMDb.php';

if (isset($_POST['query']) && strlen($_POST['query']) > 0) {

    $tvdb = new TVDb();
    $shows = $tvdb->search_tv_shows($_POST['query']);

    if (sizeof($shows) > 1) {
        foreach ($shows as $show) {
            echo "<a href=\"uitvoer.php?tvDbId=" . $show->id . "\"> " . $show->name . " [begonnen in " . $show->first_aired . "]</a><br />";
        }
    } elseif (sizeof($shows) == 1) {
        $show = $shows[0];
        header('location: uitvoer.php?tvDbId=' . $show->id . '');
    } else {
        echo "<p>Geen series gevonden met die naam. Probeer een andere omschrijving.</p>";
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Tweakers.net Serie Topic Generator</title>
</head>
<body>
<h1>Ultimation RuleZZZZ</h1>
<table border="1" style="border: 1px #000 solid;">
<form name="searchForm" method="post">
    <tr>
        <td>Voer een titel of serie nummer in</td>
        <td><input type="text" name="query" /></td>
    </tr>
    <tr>
        <td colspan="2"><input type="submit" name="search" value="Zoek serie!" /></td>
    </tr>
</form>
</table>
</body>
</html>
