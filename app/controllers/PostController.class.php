<?php

class PostController extends Controller {
    private $post;

    public function __construct() {
        $this->getModel('post');
    }

    public function create() {
        $this->displayView('post/create');
    }
}

?>