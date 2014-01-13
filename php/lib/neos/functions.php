<?php
//starting the autoloader classes (Autoloader)
set_include_path('.' . PATH_SEPARATOR . str_replace('phar:', 'phar|', LIB)
        . PATH_SEPARATOR . str_replace('phar:', 'phar|', PPHP)
        . trim(get_include_path(), ' .'));

//setting the automatic loading - Autoloader
spl_autoload_register(
        function ($class) {
            $class = ltrim('/' . strtolower(trim(strtr($class, '_\\', '//'), '/ ')), ' /\\') . '.php';
            $pth = explode(PATH_SEPARATOR, ltrim(get_include_path(), '.'));
            array_shift($pth);
            foreach ($pth as $f) {
                if (file_exists($f = str_replace('phar|', 'phar:', $f) . $class))
                    return require_once $f;
            }
        }
);
//include the autoloader Composer, if any.
if (file_exists(LIB . 'autoload.php')) include LIB . 'autoload.php';


//Debug Print 
function p($value, $exit = true){
	$o = '<pre>'.print_r($value, true).'</pre>';
	if($exit) exit($o);
	echo $o;
}


//Debug configurations
function debug($style = null){
	define('INITIME', microtime());
	error_reporting(-1);
	ini_set('error_reporting', E_ALL);
	ini_set('display_startup_errors', true);
	ini_set('display_errors', true);
}