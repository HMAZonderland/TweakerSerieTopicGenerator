<?php
/**
 * The TV Db API key to use. You can register for one here: http://thetvdb.com/?tab=apiregister
 */
define('TVDB_API_KEY', '');
define('BIERDOPJE_API_KEY', '');

define('USER_AGENT', 'TweakerSerieTopicGenerator/1.0');
define('ICON_URL', 'http://icon.ultimation.nl/');

/**
 * TRAKT API
 */
define('TRAKT_API_KEY', '');

// Date time some for comparison
date_default_timezone_set('Europe/Amsterdam');

// Tools
require_once dirname(__FILE__) . '/tools/DebugOutput.tool.php';
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
require_once dirname(__FILE__) . '/lib/IMDbApiLib/IMDb.php';
require_once dirname(__FILE__) . '/lib/IMDbApiLib/IMDbShow.php';
require_once dirname(__FILE__) . '/lib/IMDbApiLib/IMDbEpisode.php';

// Trakt
require_once dirname(__FILE__) . '/lib/TraktApiLib/trakt.php';
require_once dirname(__FILE__) . '/lib/TraktApiLib/traktShow.php';

// Tweakers
require_once dirname(__FILE__) . '/lib/TweakersLib/TweakersUBB.php';
require_once dirname(__FILE__) . '/lib/TweakersLib/TweakersSerie.php';

?>