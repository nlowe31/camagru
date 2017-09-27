<?php

class Post {
    public $pid;
    public $uid;
    public $src;
    public $created;
    public $likes;
    public $comments;

    public function __construct() {}
    
    public static function create($uid, $src) {
        return self::get(Db::insert('INSERT INTO posts (uid, src) VALUES (?, ?)', [$uid, $src]));
    }

    public static function get($pid) {
        return Db::select_object('SELECT * FROM posts WHERE pid=?', [$pid], 'Post');
    }
}

?>