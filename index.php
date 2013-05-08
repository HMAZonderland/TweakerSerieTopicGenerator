<?php
require_once dirname(__FILE__) . '/TVDb-API-Class/TVDb.php';
require_once dirname(__FILE__) . '/TVDb-API-Class/TvDbShow.php';
require_once dirname(__FILE__) . '/TVDb-API-Class/TvDbEpisode.php';

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