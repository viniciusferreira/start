<?php
//TIMER (debug only)
define('INITIME', microtime());

//Report all PHP errors - Debug only

error_reporting(-1);
ini_set('error_reporting', E_ALL);
ini_set('display_startup_errors', true);
ini_set('display_errors', true);

//Defines for CORE
defined('PPHP')     || define('PPHP', __DIR__ . '/');
defined('LIB')      || define('LIB', PPHP . 'lib/');
defined('ROOTURL')	|| define('ROOTURL', '/');

//Defines from template
defined('ROOT')     || define('ROOT', dirname($_SERVER['DOCUMENT_ROOT'] . $_SERVER['SCRIPT_NAME']) . '/');
defined('RPATH')    || define('RPATH', ((strpos(ROOT, 'phar://') === false) ? ROOT : str_replace('phar://', '', dirname(ROOT) . '/')));

//Defines from template url access
defined('URL')     	|| define('URL', 'http://'.$_SERVER['SERVER_NAME'].ROOTURL);

//Auxiliar Functions
include LIB.'neos/functions.php';

//Configurations
class_alias('Lib\Neos\Config', 'o');
o::load(PPHP.'app.ini'); //load config ini file

//Template engine
class_alias('Lib\Neos\Html\Doc', 'View'); 


//Router
$app = new Lib\Neos\Controller();
$app->setPathController(o::app('controller'));//path controller
$app->setUrl((isset($_GET['url']) ? $_GET['url'] : ''));//request url
$app->addMask('admin/login', 'administrator/login');//add mask form...

//Template Engine
$out = new Lib\Neos\Output($app->run());
$out->send();//produce and display HTML