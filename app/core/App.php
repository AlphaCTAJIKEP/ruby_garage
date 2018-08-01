<?php 
    class App{

        protected $controller = 'HomeController';

        protected $action = 'actionIndex';

        protected $params = [];

        public function __construct(){
            $url = $this->parseUrl();
            if(file_exists('../app/controllers/' . ucfirst($url[0]) . 'Controller.php')){
                $this->controller = $url[0] . 'Controller';
                unset($url['0']);
            }

            require_once '../app/controllers/' . ucfirst($this->controller) . '.php';
            $this->controller = new $this->controller;
            if(method_exists($this->controller, 'action' . ucfirst($url[1]))){
                $this->action = 'action' . ucfirst($url[1]);
                unset($url['1']);
            }

            $this->params = $url ? array_values($url) : [];
            call_user_func_array([$this->controller,$this->action],$this->params);
        }

        private function parseUrl(){
            if(isset($_GET['url'])){
                return explode('/',filter_var(rtrim($_GET['url'],'/'),FILTER_SANITIZE_URL));
            }
        }
    }