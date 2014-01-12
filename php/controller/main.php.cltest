<?php

class Main {
 
    function index(){
        return (new View('main'))->assign('teste','II')->render(false, true);
    }   
     
    function teste($arg1 = 'none', $arg2 = 'none'){
    	exit( $arg1.' - '.$arg2);
    	exit( '<pre>'.print_r($_GET, true).'</pre>');
    }
}