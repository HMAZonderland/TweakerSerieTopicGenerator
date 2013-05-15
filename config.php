<?php
/**
 * The TV Db API key to use. You can register for one here: http://thetvdb.com/?tab=apiregister
 */
define('TVDB_API_KEY', '');

// Tools
require_once dirname(__FILE__) . '/tools/C_URL.tool.php';
require_once dirname(__FILE__) . '/tools/SimpleXML.tool.php';
require_once dirname(__FILE__) . '/tools/ArrayToString.tool.php';

// Images
require_once dirname(__FILE__) . '/lib/SimpleImageLib/SimpleImage.class.php';

// TvDb
require_once dirname(__FILE__) . '/lib/TvDbApiLib/TVDb.php';
require_once dirname(__FILE__) . '/lib/TvDbApiLib/TvDbShow.php';
require_once dirname(__FILE__) . '/lib/TvDbApiLib/TvDbEpisode.php';

// IMDb
require_once dirname(__FILE__) . '/IMDbApiLib/IMDb.php';
require_once dirname(__FILE__) . '/IMDbApiLib/IMDbShow.php';

// Tweakers
require_once dirname(__FILE__) . '/TweakersLib/TweakersUBB.php';
require_once dirname(__FILE__) . '/TweakersLib/TweakersSerie.php';


?>