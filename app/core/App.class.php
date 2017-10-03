<?php

class App {

    protected $controller = 'pages';
    protected $action = 'error';
    protected $params = [];
    
    public function __construct() {
        $uri = self::parseURI();
        
        if (file_exists('app/controllers/' . $uri[0] . 'Controller.class.php')) {
            $this->controller = $uri[0];
            unset($uri[0]);
        }

        require_once('app/controllers/' . ucfirst($this->controller) . 'Controller.class.php');
        $this->controller = ucfirst($this->controller) . 'Controller';
        $this->controller = new $this->controller;

        if (isset($uri[1])) {
            if (method_exists($this->controller, $uri[1])) {
                $this->action = $uri[1];
                unset($uri[1]);
            }
        }
        
        $this->params = array_values($uri);

        call_user_func_array([$this->controller, $this->action], $this->params);
    }

    protected static function parseURI () {
        if (isset($_SERVER['REQUEST_URI'])) {
            return explode('/', filter_var(rtrim(trim($_SERVER['REQUEST_URI'], '/'), '/'), FILTER_SANITIZE_URL));
        }
    }

    public static function link($url) {
        return ('http://' . $_SERVER['SERVER_NAME'] . ':' . PORT . '/' . $url);
    }

    public static function go($url) {
        header('Location: ' . self::link($url), 301);
    }

    public static function email($to, $subject, $message) {
        $headers = "From: noreply@camagru.com\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        mail($to, $subject, $message, $headers);
    }

}

?>