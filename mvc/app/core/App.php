<?php

/**
 * 
 */
class App
{
	protected $controller = 'home';

	protected $method = 'index';

	protected $params = [];

	public function __construct()
	{
         $url =  $this->parseUrl();
         // print_r($url);
             if (file_exists('../app/controllers/'. $url[0] .'.php')) {
                      
                      // get the controller from url
                      $this->controller = $url[0];
                      // then remove the controller url form the array
                      unset($url[0]);

             }
             // Now we will get the file we need out from here
         require_once '../app/controllers/'. $this->controller .'.php';

                       $this->controller = new $this->controller;

                       // var_dump($this->controller);

                      // check if second parameter as been pass

               if (isset($url[1])) {
               	// check if method exist in controller
               	if (method_exists($this->controller, $url[1])) {
               		
               		// set the method we pass
               		$this->method = $url[1];
               		unset($url[1]);


                       	}


               }
               // let set parameter and pass some conditoin that if there is no param set to Null
               // if no value it will not pass erro
               $this->params = $url ? array_values($url) : [];

               // so now lets fire out the controller , method, and the param
               call_user_func_array([$this->controller, $this->method], $this->params);
	}
	public function parseUrl(){
		// get the url from browser directory
          if ($_GET['url']) {
          	// return the url by validating the url trim it remove the '/' and set it to array back
          	return $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
          }
	}
}