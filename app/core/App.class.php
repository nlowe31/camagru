<?php

class App {
    protected $controller = 'pages';
    protected $action = 'error';
    protected $params = [];
    
    public function __construct() {
        $uri = $this->parseURI();
        
        if (file_exists('app/controllers/' . $uri[0] . 'Controller.class.php')) {
            $this->controller = $uri[0];
            unset($uri[0]);
        }

        require_once('app/controllers/' . ucfirst($this->controller) . 'Controller.class.php');
        $this->controller = ucfirst($this->controller) . 'Controller';
        $this->controller = new $this->controller;

        if (isset($uri[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $uri[1];
                unset($uri[1]);
            }
        }
        
        if ($uri) {
            foreach ($uri as $element) {
                $get = explode('=', $element);
                $this->params[$get[0]] = $get[1];
            }
        }

        call_user_func_array([$this->controller, $this->action], $this->params);
    }

    protected function parseURI () {
        if (isset($_SERVER['REQUEST_URI'])) {
            return explode('/', filter_var(rtrim($_SERVER['REQUEST_URI'], '/'), FILTER_SANITIZE_URL));
        }
    }
}

?>