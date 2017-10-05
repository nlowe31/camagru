<?php

class PostController extends Controller {
    private $post;

    public function __construct() {
        $this->getModel('post');
    }

    public function create() {
        $this->displayView('post/create');
    }

    public function save() {
        if (!isset($_POST['image'], $_POST['filter']))
            return;
        $encodedData = str_replace('data:image/png;base64,', '', $_POST['image']);
        $encodedData = str_replace(' ', '+', $encodedData);
        $decodedData = base64_decode($encodedData);
        $img = imagecreatefromstring($decodedData);
        imageflip($img, IMG_FLIP_HORIZONTAL);

        $filter_loc = 'public/filters/resources/filters/' . htmlspecialchars($_POST['filter']);
        if (file_exists($filter_loc)) {
            $filter_size = getimagesize($filter_loc);
            $filter = imagecreatefrompng($filter_loc);
        }
//        if ($img === FALSE)
//            echo 'Problem!';

        if (!($post = Post::create(1)))
            echo 'Problem!!';

        $filename = 'userData/' . $post->pid . '.png';
        imagepng($img, $filename);
    }
}

?>