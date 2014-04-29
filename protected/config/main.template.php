<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

define("PATH_IDENTIFY", "/usr/bin/identify");
define("PATH_CONVERT", "/usr/bin/convert");
define("PATH_TESSERACT", "/usr/local/bin/tesseract");
define("PATH_JAVA", "/usr/local/java/bin/java");
define("PATH_PDFTOTEXT", "/usr/bin/pdftotext");
define("PATH_PDFBOX", "/var/www/ris3-data/pdfbox-app-1.8.4.jar");
define("PATH_PDFINFO", "/usr/bin/pdfinfo");
define("PATH_PDFTOHTML", "/usr/bin/pdftohtml");

define("PDF_PDF", "/var/www/ris3-data/data/pdf/");
define("TMP_PATH", "/tmp/");
define("LOG_PATH", "/var/www/ris3-data/logs/");
define("RU_PDF_PATH", "/var/www/ris3-data/data/ru-pdf/");
define("TILE_CACHE_DIR", "/var/www/ris3-data/tile-cache/tiles/");

define("RATSINFORMANT_BASE_URL", "https://www.ratsinformant.de");

ini_set("memory_limit", "256M");

define("SEED_KEY", "RANDOMKEY");

mb_internal_encoding("UTF-8");
mb_regex_encoding("UTF-8");
ini_set('mbstring.substitute_character', "none");
setlocale(LC_TIME, "de_DE.UTF-8");



function ris_intern_address2geo($land, $plz, $ort, $strasse)
{
	return array("lon" => 0, "lat" => 0);
}

/**
 * @param Antrag $referenz
 * @param Antrag $antrag
 * @return bool
 */
function ris_intern_antrag_ist_relevant_mlt($referenz, $antrag) {
	return true;
}


// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'   => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
	'name'       => 'Ratsinformant',

	// preloading 'log' component
	'preload'    => array('log'),

	// autoloading model and component classes
	'import'     => array(
		'application.models.*',
		'application.components.*',
		'application.components.RISParser.*',
	),

	'modules'    => array(
		// uncomment the following to enable the Gii tool
		'gii' => array(
			'class'     => 'system.gii.GiiModule',
			'password'  => 'RANDOMKEY',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			//'ipFilters' => array('*', '::1'),
		),
	),

	// application components
	'components' => array(
		'cache'        => array(
			'class' => 'system.caching.CFileCache',
		),
		'urlManager'   => array(
			'urlFormat'      => 'path',
			'showScriptName' => false,
			'rules'          => array(
				RATSINFORMANT_BASE_URL . '/'                                                                 => 'index/index',
				RATSINFORMANT_BASE_URL . '/ajax-<datum_max:[0-9\-]+>'                                        => 'index/antraegeAjax',
				RATSINFORMANT_BASE_URL . '/ba/<ba_nr:\d+>'                                                   => 'index/ba',
				RATSINFORMANT_BASE_URL . '/tiles/<style:[\d@x]+>/<width:\d+>/<zoom:\d+>/<x:\d+>/<y:\d+>.png' => 'index/tileCache',
				RATSINFORMANT_BASE_URL . '/admin/'                                                           => 'admin/index',
				RATSINFORMANT_BASE_URL . '/benachrichtigungen'                                               => 'benachrichtigungen/index',
				RATSINFORMANT_BASE_URL . '/benachrichtigungen/alleFeed/<code:[0-9\-a-z]+>'                   => 'benachrichtigungen/alleFeed',
				RATSINFORMANT_BASE_URL . '/<action:\w+>'                                                     => 'index/<action>',
				RATSINFORMANT_BASE_URL . '/<controller:\w+>/<id:\d+>'                                         => '<controller>/anzeigen',
				RATSINFORMANT_BASE_URL . '/<controller:\w+>/<action:\w+>/<id:\d+>'                            => '<controller>/<action>',
				RATSINFORMANT_BASE_URL . '/<controller:\w+>/<action:\w+>'                                     => '<controller>/<action>',
			),
		),
		'db'           => array(
			'connectionString'      => 'mysql:host=127.0.0.1;dbname=DB',
			'emulatePrepare'        => true,
			'username'              => 'ris',
			'password'              => 'PASSWORD',
			'charset'               => 'utf8',
			'queryCacheID'          => 'apcCache',
			'schemaCachingDuration' => 3600,
		),
		'errorHandler' => array(
			// use 'site/error' action to display errors
			'errorAction' => 'index/error',
		),
		'log'          => array(
			'class'  => 'CLogRouter',
			'routes' => array(
				array(
					'class'  => 'CFileLogRoute',
					'levels' => 'error, warning',
				),
				/*
				array(
					'class' => 'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'     => array(
		// this is used in contact page
		'adminEmail'     => 'info@ratsinformant.de',
		'adminEmailName' => "Ratsinformant",
		'cloudmateKey'   => 'KEY',
		'skobblerKey'    => 'KEY',
		'baseURL'        => RATSINFORMANT_BASE_URL,
		'debug_log'      => true,
	),
);