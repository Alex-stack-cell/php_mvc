<?php   
    /**
     * App Core Class
     * Creates URL & maps it to the controller
     * URL FORMAT - /controller/method/params
     */
    class Core {
        protected $currentController = 'Pages';
        protected $currentMethod = 'index';
        protected $params = [];

        public function __construct(){
            $url = $this->getUrl();
   
            //Look in controllers for first value
             if(isset($url)){
                if (file_exists('../app/controllers/'.ucwords($url[0]).'.php')) {
                //If exists, set as controller
                $this->currentController = ucwords($url[0]);              
                //Unset 0 index
                unset($url[0]);
                }
             }
        
            //Require the controller
            require_once '../app/controllers/'.$this->currentController.'.php';

            //Instanciate controller class
            $this->currentController = new $this->currentController;

            //Check for second part of url
            if(isset($url[1])){
                //check if method exists in controller
                if(method_exists($this->currentController, $url[1])){
                    $this->currentMethod = $url[1];
                    //Unsent 1 index
                    unset($url[1]);
                }
            }

            // Get params
            $this->params = $url ? array_values($url) : [];

            //Call a callback with array of params
            call_user_func_array([$this->currentController,$this->currentMethod],$this->params);
            // echo $this->currentMethod;
        }
        
        /**
         * Method responsible for getting the url on the browser
         * if the url is set and returning its value, null otherwise.
         * It removes all illegal characteres and white spaces
         */
        public function getUrl(){
            if(isset($_GET['url'])){
                $url = rtrim($_GET['url'],'/');
                //removes all illegal URL characters from a string
                $url = filter_var($url,FILTER_SANITIZE_URL);
                // split a string into an array of char. e.g [post/blog/2]
                $url = explode('/',$url);           
                return $url;
            }                     
        }
    }