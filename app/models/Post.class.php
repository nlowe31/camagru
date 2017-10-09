<?php

class Post {
    public $pid;
    public $uid;
    public $username;
    public $src;
    public $created;
    public $confirmed;
    public $likeCount;
    public $likes;
    public $comments;

    public function __construct() {
        $this->getComments();
    }
    
    public static function create($uid) {
        return self::get(Db::insert('INSERT INTO posts (uid) VALUES (?)', [$uid]));
    }

    public static function get($pid) {
        return Db::select_one_object('SELECT p.*, COUNT(DISTINCT l.lid) AS likeCount, u.username AS username FROM posts p LEFT JOIN likes l ON p.pid=l.pid LEFT JOIN users u ON p.uid = u.uid WHERE p.pid=? GROUP BY p.pid LIMIT 1', [$pid], 'Post');
    }

     public function push() {
        $count = Db::update('UPDATE posts SET uid=?, src=?, confirmed=? WHERE pid=?', [$this->uid, $this->src, $this->confirmed, $this->pid]);
        if ($count > 0)
            return TRUE;
        return FALSE;
    }

    public static function getAll($qty) {
        return Db::select_all_object('SELECT p.*, COUNT(DISTINCT l.lid) AS likeCount, u.username AS username FROM posts p LEFT JOIN likes l ON p.pid=l.pid LEFT JOIN users u ON p.uid = u.uid GROUP BY p.pid HAVING p.confirmed=1 ORDER BY p.pid DESC LIMIT ?', [$qty], 'Post');
    }

    public static function getSome($last, $qty) {
        $posts = Db::select_all_object('SELECT p.*, COUNT(DISTINCT l.lid) AS likeCount, u.username AS username FROM posts p LEFT JOIN likes l ON p.pid=l.pid LEFT JOIN users u ON p.uid = u.uid WHERE p.pid<? GROUP BY p.pid HAVING p.confirmed=1 ORDER BY p.pid DESC LIMIT ?', [$last, $qty], 'Post');
        return $posts;
    }

    public function getComments() {
        $this->comments = Db::select_all_object('SELECT c.*, u.username FROM comments c LEFT JOIN users u ON C.uid=u.uid WHERE pid=? GROUP BY c.cid', [$this->pid], 'Comment');
    }

//    public function getLikes() {
//        $this->likes = Db::select_all('SELECT * FROM likes WHERE pid=?', [$this->pid]);
//    }

    public function addLike($uid) {
        return Db::insert('INSERT INTO likes (pid, uid) VALUES (?, ?)', [$this->pid, $uid]);
    }

    public function removeLike($uid) {
        return Db::insert('DELETE FROM likes WHERE pid=? AND uid=?', [$this->pid, $uid]);
    }

    public function isLiked($uid) {
        $count = Db::update('SELECT lid FROM likes WHERE pid=? AND uid=?', [$this->pid, $uid]);
        if ($count !== 0 && $count !== FALSE)
            return TRUE;
        return FALSE;
    }

    public function addComment($uid, $text) {
        return Db::insert('INSERT INTO comments (pid, uid, text) VALUES (?, ?, ?)', [$this->pid, $uid, $text]);
    }

    public function removeComment($cid) {
        return Db::insert('DELETE FROM comments WHERE cid=?', [$cid]);
    }

    public function delete() {
        $filename = substr($this->src, 1);
        if (file_exists($filename)) {
            unlink($filename);
        }
        $count = Db::update('DELETE FROM posts WHERE pid=?', [$this->pid]);
        if ($count > 0)
            return TRUE;
        return FALSE;
    }
}

?>