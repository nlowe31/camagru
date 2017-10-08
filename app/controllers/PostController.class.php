<?php

class PostController extends Controller {
    private $paginate = 5;

    public function __construct() {
        $this->getModel('post');
        $this->getModel('comment');
    }

    public function create() {
        $this->displayView('post/create');
    }

    public function all() {
//        $posts = Post::getSome(100, $this->paginate);
//        $posts = Post::getAll();
        $this->displayView('post/index', ['posts' => Post::getAll($this->paginate)]);
    }

    public function save() {
        if (isset($_POST['image'], $_POST['filter'], $_SESSION['auth'])) {
            $encodedData = str_replace('data:image/png;base64,', '', $_POST['image']);
            $encodedData = str_replace(' ', '+', $encodedData);
            $decodedData = base64_decode($encodedData);
            $img = imagecreatefromstring($decodedData);
            $img = imagescale($img, 600);

            $filter_loc = 'public/resources/filters/' . htmlspecialchars($_POST['filter']) . '.png';
            if (file_exists($filter_loc)) {
                $filter = imagecreatefrompng($filter_loc);
                $filter = imagescale($filter, 600);
                imageflip($filter, IMG_FLIP_HORIZONTAL);
                imagecopy($img, $filter, 0, 0, 0, 0, imagesx($filter) - 1, imagesy($filter) - 1);
            }
            if ($post = Post::create($_SESSION['auth'])) {
                $filename = 'userData/' . $post->pid . '.png';
                if (imagepng($img, $filename)) {
                    $post->src = '/' . $filename;
                    $post->push();
                    echo $post->pid;
                    return;
                }
            }
        }
        echo 'ERROR';
    }

    public function decide() {
        if (isset($_POST['pid'], $_POST['decision'], $_SESSION['auth'])) {
            $post = Post::get($_POST['pid']);
            if ($post->uid === $_SESSION['auth']) {
                if ($_POST['decision'] === 'approve') {
                    $post->confirmed = 1;
                    $post->push();
                    echo 'SUCCESS';
                    return ;
                }
                else {
                    $post->delete();
                    echo 'SUCCESS';
                    return ;
                }
            }
        }
        echo 'ERROR';
    }

    public function scroll() {
        if (!isset($_POST['last']))
            return ;
        $this->callView('post/loadPosts', ['posts' => Post::getSome($_POST['last'], $this->paginate)]);
    }

    public function loadComments() {
        if (!isset($_POST['pid']))
            return ;
        $this->callView('post/showComments', ['post' => Post::get($_POST['pid'])]);
    }

    public function postComment() {
        if (!isset($_POST['pid'], $_POST['text'], $_SESSION['auth']))
            return ;
        if (($post = Post::get($_POST['pid'])) && ($post->addComment($_SESSION['auth'], $_POST['text']))) {
            echo 'SUCCESS';
        }
        else
            echo 'ERROR';
    }
}

?>