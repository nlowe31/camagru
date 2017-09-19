<?php

class Controller {

    protected function getModel($model) {
        require_once('app/models/' . ucfirst($model) . '.class.php');
    }

    protected function header() {
        require_once('app/views/templates/header.php');
    }

    protected function footer() {
        require_once('app/views/templates/footer.php');        
    }

    protected function displayView($view, $data = []) {
        $this->header();
        extract($data);
        require_once('app/views/' . $view . '.php');
        $this->footer();
    }
}

?>