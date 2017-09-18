<?php

class Router {
    public $uri;
    public $controller;
    public $action;
    public $params;

    public function __construct($address = NULL) {
        $this->uri = array_reverse(explode('/', (isset($address) ? $address : $_SERVER['REQUEST_URI'])));
        array_pop($this->uri);
        $this->controller = array_pop($this->uri);
        $this->action = array_pop($this->uri);
        foreach ($this->uri as $element) {
            $get = explode(':', $element);
            $this->params[$get[0]] = $get[1];
        }
    }

    public static function redirect($uri) {
        
    }
}

?>