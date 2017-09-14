<?php

class PagesController {
    public function home() {
        require_once('views/home.php');
    }

    public function error() {
        require_once('views/error.php');
    }
}

?>