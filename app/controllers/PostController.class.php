<?php

class PostController extends Controller {
    private $paginate = 10;

    public function __construct() {
        $this->getModel('post');
        $this->getModel('comment');
        $this->getModel('user');
    }

    public function index() {
        $this->all();
    }

    public function create() {
        if (isset($_SESSION['auth']))
            $this->displayView('post/create', ['posts' => Post::getAllFromUser($_SESSION['auth'], $this->paginate)]);
        else
            App::go('user/login');          
    }

    public function all() {
        $auth = (isset($_SESSION['auth'])) ? true : false;
        $this->displayView('post/viewAll', ['posts' => Post::getAll($this->paginate), 'scrollURL' => '/post/scroll', 'auth' => $auth]);
    }

    public function myPosts() {
        if (isset($_SESSION['auth']))
            $this->displayView('post/viewAll', ['posts' => Post::getAllFromUser($_SESSION['auth'], $this->paginate), 'scrollURL' => '/post/scrollUser']);
        else
            $this->all();
    }

    public function show($pid = NULL) {
        $auth = (isset($_SESSION['auth'])) ? true : false;
        print_r($pid);
        if (isset($pid) && ($post = Post::get($pid)))
            $this->displayView('post/showPost', ['post' => $post, 'auth' => $auth]);
        else
            $this->all();
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
        if (!isset($_POST['last']) || $_POST['last'] === "-1")
            return ;
        $this->callView('post/showPosts', ['posts' => Post::getSome($_POST['last'], $this->paginate)]);
    }

    public function scrollUser() {
        if (!isset($_POST['last'], $_SESSION['auth']))
            return ;
        $this->callView('post/showPosts', ['posts' => Post::getSomeFromUser($_SESSION['auth'], $_POST['last'], $this->paginate)]);
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
        if (isset($_POST['pid'], $_SESSION['auth']) && !empty($_POST['text']) && ($post = Post::get($_POST['pid'])) && ($post->addComment($_SESSION['auth'], $_POST['text']))) {
            $this->notify($post, $_SESSION['auth'], 'comment', $_POST['text']);
            echo 'SUCCESS';
        }
        else
            echo 'ERROR';
    }

    public function like() {
        if (!isset($_POST['pid'], $_SESSION['auth']))
            return ;
        $post = Post::get($_POST['pid']);
        if ($post->isLiked($_SESSION['auth'])) {          
            $post->removeLike($_SESSION['auth']);            
        }
        else {
            $post->addLike($_SESSION['auth']);                   
            $this->notify($post, $_SESSION['auth'], 'like');                  
        }
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

    private function notify($post, $from, $action, $text = '') {
        $to = User::get($post->uid);
        $from = User::get($from);
        $message = '';
        if ($to === FALSE || ($to->notifications == 0) || $from === FALSE)
            return ;
        if ($action === 'like')
            $message = '<p>Hi ' . htmlspecialchars($to->firstName) . ',</p><p><i>' . htmlspecialchars($from->username) . '</i> just liked your <a href="' . App::link('post/show/' . $post->pid) . '">post.</a></p><br>Best,<br>The Camagru Team';
        else if ($action === 'comment')
            $message = '<p>Hi ' . htmlspecialchars($to->firstName) . ',</p><br><p><i>' . htmlspecialchars($from->username) . '</i> just commented on your <a href="' . App::link('post/show/' . $post->pid) . '">post.</a></p><p>"<quote>' . htmlspecialchars($text) . '</quote>"</p><br>Best,<br>The Camagru Team';
        App::email($to->email, 'New ' . $action, $message);
    }
}

?>