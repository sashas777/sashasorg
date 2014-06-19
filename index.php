<?php
/**
 * Put errors on ON for debugging this file
 */
ini_set('display_errors',1);
error_reporting(E_ALL ^ E_DEPRECATED);

/*
 * Define the application environment
 */
define('APPLICATION_ENV', 'production');

/*
 * Defines the directory separator for windows or unix env
 */
define('DS', DIRECTORY_SEPARATOR);
$path=$_SERVER['DOCUMENT_ROOT'].DS;

/* Custom modules*/
 include_once('recaptchalib.php');

/**
 * Define the absolute/relative paths to the library path, the app library path,
 * app path and the database configuration path 
 */
define('ZEND_LIBRARY_PATH', realpath('library'.DS.'Zend'));
define('APPLICATION_PATH', 'app');
define('APP_LIBRARY_PATH', 'library');

$paths = array(
	ZEND_LIBRARY_PATH,
	APP_LIBRARY_PATH,
	get_include_path()
);

/**
 * Set the include paths to point to the new defined paths
 */
set_include_path(implode(PATH_SEPARATOR, $paths));

/** Zend_Application */
require_once APP_LIBRARY_PATH.DS.'Zend'.DS.'Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV, 
    APPLICATION_PATH . DS .  'configs' . DS . 'app.ini'
);

 
//Start
$application->bootstrap();
$application->run();
