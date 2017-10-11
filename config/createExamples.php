<?php

require_once('app/core/Db.class.php');
require_once('app/core/App.class.php');
require_once('app/models/User.class.php');
require_once('app/models/Post.class.php');
require_once('app/models/Comment.class.php');

$users[] = User::create('nlowe', 'nlowe31@gmail.com', 'lolol', 'Nate', 'Lowe');
$users[] = User::create('test1', 'test1@fake.com', 'lolol', 'Test', 'Un');
$users[] = User::create('test2', 'test2@fake.com', 'lolol', 'Test', 'Deux');
$users[] = User::create('test3', 'test3@fake.com', 'lolol', 'Test', 'Trois');

foreach ($users as $user) {
    $user->confirmed = 1;
    $user->push();
    $post = Post::create($user->uid);
    $newPath = 'userData/' . $post->pid . '.png';
    copy('userData/example.png', $newPath);
    $post->src = '/' . $newPath;
    $post->confirmed = 1;
    $post->push();
}

