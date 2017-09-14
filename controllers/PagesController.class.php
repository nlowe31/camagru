<?php

class PagesController {
    public function home() {
        require_once($root . 'views/home.php');
    }

    public function error() {
        require_once($root . 'views/error.php');
    }
}

?>