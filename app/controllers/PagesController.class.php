<?php

class PagesController extends Controller {
    public function home() {
        $this->displayView('pages/home');
    }

    public function error() {
        $this->displayView('pages/error');
    }
}

?>