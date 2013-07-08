<?php
ob_start();

// Config + includes
require_once dirname(__FILE__) . '/config.php';

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Tweakers.net Serie Topic Generator</title>
    <link href="css/formatting.css" rel="stylesheet">
    <link href="less/metro.less" rel="stylesheet/less" type="text/css"/>
    <link href="less/metroblog.less" rel="stylesheet/less" type="text/css"/>
    <script src="scripts/less-1.2.1.min.js" type="text/javascript"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery/jquery-1.7.2.min.js"></script>
    <script src="scripts/jquery.metro.js" type="text/javascript"></script>
    <script src="scripts/jscolor/jscolor.js" type="text/javascript"></script>
</head>
<body>
<?php

if (isset($_POST['query']) && strlen($_POST['query']) > 0) {

    $tvdb = new TVDb();
    $shows = $tvdb->search_tv_shows($_POST['query']);

    // Colors
    $borderColor = $_POST['borderColor'];
    $tableBgColor = $_POST['tableBgColor'];
    $tdBgColor = $_POST['tdBgColor'];
    $thBgColor = $_POST['thBgColor'];

    if (sizeof($shows) > 1) {
        echo "<serielijst>";
        echo "<h3 class=\"accent\">Welk van onderstaande series?</h3><br />";
        foreach ($shows as $show) {
            echo "<h6 class=\"accent\"><a href=\"uitvoer.php?tvDbId=" . $show->id . "&borderColor=" . $borderColor . "&tableBgColor=" . $tableBgColor . "&tdBgColor=" . $tdBgColor . "&thBgColor=" . $thBgColor . "\">" . $show->name . " [begonnen in " . $show->first_aired . "]</a></h6><br />";
        }
        echo "</serielijst><br /><br />";
    } elseif (sizeof($shows) == 1) {
        $show = $shows[0];
        header('location: uitvoer.php?tvDbId=' . $show->id . '&borderColor=' . $borderColor . '&tableBgColor=' . $tableBgColor . '&tdBgColor=' . $tdBgColor . '&thBgColor=' . $thBgColor);
    } else {
        echo "<section>";
        echo "<h3 class=\"accent\">Geen series gevonden met die naam</h3>";
        echo "<h6 class=\"accent\"><a href=\"index.php\">Probeer het opnieuw</a></h6>";
        echo "</section>";
    }
} else {
    ?>
    <section>
        <h2 class="accent">Voer een titel in</h2>
        <br/>

        <form name="searchForm" method="post">
            <table>
                <tr>
                    <td>Selecteer een border color</td>
                    <td><input name="borderColor" class="color" value="000000"></td>
                </tr>
                <tr>
                    <td>Selecteer een tabel background color</td>
                    <td><input name="tableBgColor" class="color" value="FFFFFF"></td>
                </tr>
                <tr>
                    <td>Selecteer een td background color</td>
                    <td><input name="tdBgColor" class="color" value="FFFFFF"></td>
                </tr>
                <tr>
                    <td>Selecteer een th background color</td>
                    <td><input name="thBgColor" class="color" value="000000"></td>
                </tr>
            </table>
            <div class="inputwrap">
                <p><input type="text" name="query" size="46"/><input type="submit" name="search" value="Zoek serie!"/>
                </p>
            </div>
        </form>
    </section>
<?php
}
?>
</body>
</html>