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
        if (!isset($_POST['image'], $_POST['filter'], $_SESSION['auth']))
            return;
        $encodedData = str_replace('data:image/png;base64,', '', $_POST['image']);
        $encodedData = str_replace(' ', '+', $encodedData);
        $decodedData = base64_decode($encodedData);
        $img = imagecreatefromstring($decodedData);
        imageflip($img, IMG_FLIP_HORIZONTAL);
        $img = imagescale($img, 500);

        $filter_loc = 'public/resources/filters/' . htmlspecialchars($_POST['filter']) . '.png';
        if (file_exists($filter_loc)) {
            $filter = imagecreatefrompng($filter_loc);
            $filter = imagescale($filter, 500);
            imagecopy($img, $filter, 0, 0, 0, 0, imagesx($filter) - 1, imagesy($filter) - 1);
        }
        if ($post = Post::create($_SESSION['auth'])) {
            $filename = 'userData/' . $post->pid . '.png';
            if (imagepng($img, $filename)) {
                $post->src = '/' . $filename;
                $post->push();
            }
        }
    }

    private function resize($original, $size)
    {
        $width = 400;

        $height = ($width * $size[1]) / $size[0];
        $ret = imagecreatetruecolor($width, $height);
        imagealphablending($ret, false);
        imagesavealpha($ret,true);
        $transparent = imagecolorallocatealpha($ret, 255, 255, 255, 127);
        imagefilledrectangle($ret, 0, 0, $width, $height, $transparent);
        imagecopyresampled($ret, $original, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
        return $ret;
    }
}

?>