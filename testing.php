<?php
// error_reporting( E_ALL );

// include('Db.class.php');
// include('User.class.php');
// include('Form.class.php');

// $db = Db::get();

// echo (Db::insert('INSERT INTO users (email, firstName) VALUES (?, ?)', ['nlowe31@gmail.com', 'Nate']));
// echo (Db::insert('UPDATE users SET firstName=? WHERE email=?', ['YES', 'nlowe31@gmail.com']) . "\n");
// print_r(User::create('aidz', 'lol', 'Yes', 'No'));
// $current = User::findByEmail('aidzz');
// echo $current->firstName . "\n";
// $current->firstName = 'yes';
// echo $current->firstName . "\n";
// echo $current->update() . "\n";
// print_r(User::get($current->uid));

// print_r(User::create('nate@gmail.com', 'lolol', 'Nate', 'Lowe'));
// $current = User::findByEmail('nate@gmail.com');
// print_r($current->authenticate('lolol'));

// $form = new Form('target="/"');
// $form->input('text', 'box', '24', 'lol');
// $form->hidden('lol');
// $form->text();
// $form->put();

// session_start();
// require_once('controllers/UserController.class.php');
// $userController = new UserController;
// $_POST['email'] = 'nate@gmail.com';
// $_POST['password'] = 'lolol';
// $_POST['Login'] = 'Login';

// $user = User::findByEmail($_POST['email']);

// $userController->auth();
// // $userController->loginSuccess();

// echo $host  = $_SERVER['HTTP_HOST'];

error_reporting(E_ALL);

// require_once('Router.class.php');
// $test = new Router('/lolol/yes/no');
// echo $test->controller;
// print_r($test);

require_once('app/core/Controller.class.php');
require_once('app/core/Db.class.php');
require_once('app/core/App.class.php');
require_once('app/models/User.class.php');
require_once('app/models/Post.class.php');
require_once('app/models/Comment.class.php');
require_once('app/controllers/UserController.class.php');
require_once('app/controllers/PostController.class.php');

// $controller = new UserController();

// App::email('nlowe31@gmail.com', 'Testing', '123');

// $controller->myAccount();

// date_default_timezone_set("Europe/Paris");
// echo hash("md5", date(DateTime::W3C));

// $post = Post::get(4);
// echo $post->comments . PHP_EOL;
// print_r($post->getComments());

// $all = Post::getAll();

// // foreach($all as $post) {
// //     print_r($post);
// // }

// for($i = 0; $i < 2; $i++){
//     print_r($all->fetch());
// }

//$user = User::findByUsername('nlowe31');
//$user->confirmed = 1;
//$user->push();

//App::go('user/myAccount');

//$poster = new PostController();
//
//$png = file_get_contents('download.png');
//$encoded = base64_encode($png);
//$_POST['image'] = $encoded;
//$poster->upload();

//$post = Post::get(27);
//$post->confirmed = 1;
//$post->push();
//
//$post->addComment(19, "lololol");
//
//print_r($post);

//$posts = Post::getAll();
//
//print_r($posts);
//
$pc = new PostController();
////
////$_POST['current'] = 1;
////print_r(json_encode($pc->getPosts()));
//
////require_once('app/views/post/index.php');
//
//$_POST['last'] = 100;
//$pc->scroll();

//$post = Post::get(102);
//
//$post->addLike(19);
//
//if ($post->isLiked(19))
//    echo 'YES (1)';
//
//$post->removeLike(19);
//
//if ($post->isLiked(19))
//    echo 'YES (2)';

$_POST['pid'] = 102;
$_SESSION['auth'] = 19;

$pc->like();

?>