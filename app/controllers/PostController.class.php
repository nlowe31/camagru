<?php

class PostController extends Controller {
    private $paginate = 10;

    public function __construct() {
        $this->getModel('post');
        $this->getModel('comment');
    }

    public function create() {
        $this->displayView('post/create', ['posts' => Post::getAllFromUser($_SESSION['auth'], $this->paginate)]);
    }

    public function all() {
        $this->displayView('post/viewAll', ['posts' => Post::getAll($this->paginate)]);
    }

    public function take() {
        if (isset($_POST['image'], $_POST['filter'], $_SESSION['auth'])) {
            $encodedData = str_replace('data:image/png;base64,', '', $_POST['image']);
            $encodedData = str_replace(' ', '+', $encodedData);
            $decodedData = base64_decode($encodedData);
            $img = imagecreatefromstring($decodedData);
            imageflip($img, IMG_FLIP_HORIZONTAL);
            $this->save($img, htmlspecialchars($_POST['filter']), $_SESSION['auth']);
        }
        else
            echo 'ERROR';
    }

    public function upload() {
        if (isset($_FILES['image'], $_POST['filter'], $_SESSION['auth'])) {
            if ($_FILES['image']['size'] < 2000000) {
                $supported = ['png', 'jpg', 'jpeg'];
                $extension = pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION);
                if (in_array($extension, $supported)) {
                    $img = FALSE;
                    if ($extension === 'png') {
                        $img = imagecreatefrompng($_FILES['image']['tmp_name']);
                    }
                    else if ($extension === 'jpg' || $extension === 'jpeg') {
                        $img = imagecreatefromjpeg($_FILES['image']['tmp_name']);
                    }
                    if ($img !== FALSE)
                        return ($this->save($img, htmlspecialchars($_POST['filter']), $_SESSION['auth']));
                }
            }
        }
        echo 'ERROR';
    }

    private function save($img, $filter_name, $uid) {
        $img = imagescale($img, 600);

        $filter_loc = 'public/resources/filters/' . $filter_name . '.png';
        if (file_exists($filter_loc)) {
            $filter = imagecreatefrompng($filter_loc);
            $filter = imagescale($filter, 600);
            imagecopy($img, $filter, 0, 0, 0, 0, imagesx($filter) - 1, imagesy($filter) - 1);
        }
        if ($post = Post::create($uid)) {
            $filename = 'userData/' . $post->pid . '.png';
            if (imagepng($img, $filename)) {
                $post->src = '/' . $filename;
                $post->push();
                echo $post->pid;
                return;
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
                    echo 'APPROVE';
                    return ;
                }
                else {
                    $post->delete();
                    echo 'DISAPPROVE';
                    return ;
                }
            }
        }
        echo 'ERROR';
    }

    public function scroll() {
        if (!isset($_POST['last']))
            return ;
        $this->callView('post/showPosts', ['posts' => Post::getSome($_POST['last'], $this->paginate)]);
    }

    public function scrollMini() {
        if (!isset($_POST['last'], $_SESSION['auth']))
            return ;
        $this->callView('post/showMiniPosts', ['posts' => Post::getSomeFromUser($_SESSION['auth'], $_POST['last'], $this->paginate)]);
    }

    public function loadMini() {
        if (!isset($_POST['pid'], $_SESSION['auth']))
            return ;
        $this->callView('post/showMiniPost', ['post' => Post::get($_POST['pid'])]);
    }

    public function loadComments() {
        if (!isset($_POST['pid']))
            return ;
        $this->callView('post/showComments', ['post' => Post::get($_POST['pid'])]);
    }

    public function postComment() {
        if (!isset($_POST['pid'], $_POST['text'], $_SESSION['auth']) || $_POST['text'] === '') {
            echo 'ERROR';
            return ;
        }
        if (($post = Post::get($_POST['pid'])) && ($post->addComment($_SESSION['auth'], $_POST['text']))) {
            echo 'SUCCESS';
        }
        else
            echo 'ERROR';
    }

    public function like() {
        if (!isset($_POST['pid'], $_SESSION['auth']))
            return ;
        $post = Post::get($_POST['pid']);

        if ($post->isLiked($_SESSION['auth']))
            $post->removeLike($_SESSION['auth']);
        else
            $post->addLike($_SESSION['auth']);

        $post = Post::get($post->pid);
        $this->callView('post/showTop', ['post' => $post]);
    }

    public function delete() {
        if (!isset($_POST['pid'], $_SESSION['auth']))
            return ;
        if ($post = Post::get($_POST['pid'])) {
            if ($post->uid === $_SESSION['auth']) {
                if ($post->delete()) {
                    echo 'SUCCESS';
                    return ;
                }
            }
        }
        echo 'ERROR';
    }
}

?>