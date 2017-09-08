<?php

class User {
    public $uid;
    public $email;
    public $firstName;
    public $lastName;

    public function __construct($uid, $email, $firstName, $lastName) {
        $this->uid = $uid;
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public static function get($uid) {
        $db = Db::get();
        $stmt = $pdo->prepare('SELECT * FROM users WHERE uid=:uid');
        $stmt->execute(['uid' => $uid]);
        $user = $stmt->fetch();

        return new User($user['uid'], $user['email'], $user['firstName'], $user['lastName']);
    }

    public static function find($email) {
        $db = Db::get();
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email=:email');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        return new User($user['uid'], $user['email'], $user['firstName'], $user['lastName']);
    }

    public function push() {
        
    }
}
?>
