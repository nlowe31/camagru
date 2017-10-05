<?php

class Post {
    public $pid;
    public $uid;
    public $src;
    public $created;
    public $likes;
    public $comments;

    public function __construct() {}
    
    public static function create($uid) {
        return self::get(Db::insert('INSERT INTO posts (uid) VALUES (?)', [$uid]));
    }

    public static function get($pid) {
        return Db::select_object('SELECT p.*, COUNT(DISTINCT l.lid) AS likes, COUNT(DISTINCT c.cid) AS comments FROM posts p LEFT JOIN likes l ON p.pid=l.pid LEFT JOIN comments c ON p.pid=c.pid WHERE p.pid=? GROUP BY p.pid', [$pid], 'Post');
    }

     public function push() {
        $count = Db::update('UPDATE posts SET uid=?, src=? WHERE pid=?', [$this->uid, $this->src, $this->pid]);
        if ($count > 0)
            return TRUE;
        return FALSE;
    }

    public static function getAll() {
        return Db::select('SELECT p.*, COUNT(DISTINCT l.lid) AS likes, COUNT(DISTINCT c.cid) AS comments FROM posts p LEFT JOIN likes l ON p.pid=l.pid LEFT JOIN comments c ON p.pid=c.pid GROUP BY p.pid', NULL);        
    }

    public function getComments() {
        return Db::select_array('SELECT * FROM comments WHERE pid=?', [$this->pid]);
    }

    public function getLikes() {
        return Db::select_array('SELECT * FROM likes WHERE pid=?', [$this->pid]);        
    }

    public function addLike($uid) {
        return Db::insert('INSERT INTO likes (pid, uid) VALUES (?, ?)', [$this->pid, $uid]);
    }

    public function removeLike($uid) {
        return Db::insert('DELETE FROM likes WHERE pid=? AND uid=?', [$this->pid, $uid]);
    }

    public function addComment($uid, $text) {
        return Db::insert('INSERT INTO comments (pid, uid) VALUES (?, ?, ?)', [$this->pid, $uid, $text]);
    }

    public function removeComment($cid) {
        return Db::insert('DELETE FROM comments WHERE cid=?', [$cid]);
    }
}

?>