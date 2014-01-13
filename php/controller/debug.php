<?php

class Debug {
 
    function index(){
        return (new View('main'))->assign('msg','Debug Mode')->render(true, true, true);
    }   
     
    function teste($arg1 = 'none', $arg2 = 'none'){
    	exit( var_dump($this) . $arg1.' - '.$arg2);
    	exit( '<pre>'.print_r($_GET, true).'</pre>');
    }
}