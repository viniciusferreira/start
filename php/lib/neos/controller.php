<?php

namespace Lib\Neos;

class Controller {
    
    //Parameters
    private $url = 'url';
    private $mask = array();
    private $pathcontroller = '';
    private $defcontroller = 'main';
    private $defaction = 'index';
    private $parms = array();
    
    
    function __construct($url = false, $pathcontroller = false, $defcontroller = false, $defaction = false){
        if($url != false) $this->url = $url;
		if($pathcontroller != false) $this->pathcontroller = $pathcontroller;
		if($defcontroller != false) $this->defcontroller = $defcontroller;
		if($defaction != false) $this->defaction = $defaction;
    }
    
    //get/set parameters
	function __call($nm, $arg){
		$nm = strtolower($nm);
		$arg = isset($arg[0]) ? $arg[0] : null;
		$func = substr($nm, 0, 3);
		$par = substr($nm, 3);

		//parameter exists?
		if(isset($this->$par)){
			if($func == 'set') {
			    $this->$par = $arg;
			    return $this;
			}
			if($func == 'get') return $this->$par; 
		}
		return false;
	}
    
    
    
    /* RUN
     * Running the application front controller
     *
     */
    function run() {
        //breaking the url . . .
        $url = explode('/', trim($this->url, ' /').'/');
    
        //finding a controller -------------------------------------
        $controller = strtolower((isset($url[0]) && $url[0] != '') ? $url[0] : $this->defcontroller); //default
        
        //passing control to the controller class
        $pathCtrl = $this->pathcontroller . $controller . '.php';
        if (file_exists($pathCtrl)) {
            include $pathCtrl;
            if (isset($url[0]) && $controller == $url[0]) array_shift($url);
        } elseif (file_exists($this->pathcontroller . $this->defcontroller . '.php')) {
            include $this->pathcontroller . $this->defcontroller . '.php';
            $controller = $this->defcontroller;
            array_unshift($url, $this->defcontroller);
        } else return false;
        
        //new controller
        $controller = ucfirst($controller);
        $controller = new $controller($res);
    
        //finding a action -----------------------------------------
        $action = (isset($url[0]) && $url[0] != '' && method_exists($controller, $url[0])) ? strtolower($url[0]) : $this->defaction; //default
        if(isset($url[0]) && $action == $url[0]) array_shift($url);
        
        //collecting parameters ------------------------------------
        if (!is_array($url)) $url = Array();
        $this->parms;
    
        //run controller action and return -------------------------
        return call_user_func_array(array($controller, $action), $url);
    }
    
    /* ADDMASK
     * Add mask in url decoder
     *
     */
    function addMask($mask, $result){
        $this->mask[$mask] = $result;
        return $this;
    }

}