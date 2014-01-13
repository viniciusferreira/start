<?php
//Defines for CORE
defined('PPHP')     || define('PPHP', __DIR__ . '/');
defined('LIB')      || define('LIB', PPHP . 'lib/');

//Auxiliar Functions
include LIB.'neos/functions.php';

debug();//Debug Only

//Defines for template
defined('ROOT')     || define('ROOT', dirname($_SERVER['DOCUMENT_ROOT'] . $_SERVER['SCRIPT_NAME']) . '/');
defined('RPATH')    || define('RPATH', ((strpos(ROOT, 'phar://') === false) ? ROOT : str_replace('phar://', '', dirname(ROOT) . '/')));

//Defines for template to url access
$base = rtrim(str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']), ' /');
defined('REQST')    || define('REQST', trim(str_replace($base, '', $_SERVER['REQUEST_URI']), ' /'));
defined('URL')      || define('URL', 'http://'.$_SERVER['SERVER_NAME'].$base.'/');

//Configurations
class_alias('Lib\Neos\Config', 'o');
o::load(PPHP.'app.ini'); //load config ini file

//Template alias
class_alias('Lib\Neos\Html\Doc', 'View');

//Decode route and instantiate controller
$controller = new Lib\Neos\Controller(REQST, o::app('controller'));

//Template Engine
$out = new Lib\Neos\Output($controller->run());
$out->send();//produce and display HTML
