<?php

class User {
    public $uid;
    public $email;
    public $firstName;
    public $lastName;
    public $created;
    public $confirmed;

    public function __construct($uid, $email, $firstName, $lastName, $created, $confirmed) {
        $this->uid = $uid;
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->created = $created;
        $this->confirmed = $confirmed;
    }

    public static function create($email, $password, $firstName, $lastName) {

    public static function get($uid) {
        $db = Db::get();
        $stmt = $pdo->prepare('SELECT * FROM users WHERE uid=:uid');
        $stmt->execute(['uid' => $uid]);
        $user = $stmt->fetch();

        return new User($user['uid'], $user['email'], $user['firstName'], $user['lastName'], $user['created'], $user['confirmed']);
    }

    public static function find($email) {
        $db = Db::get();
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email=:email');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        return new User($user['uid'], $user['email'], $user['firstName'], $user['lastName'], $user['created'], $user['confirmed']);
    }

    public function update() {
        $db = Db::get();
        $stmt = $pdo->prepare('UPDATE users SET email=:email, firstName=:firstName, lastName=:lastName, confirmed=:confirmed WHERE uid=:uid');
        $stmt->execute(['email' => $this->email],
            ['firstName' => $this->firstName],
            ['lastName' => $this->lastName],
            ['confirmed' => $this->confirmed],
            ['uid' => $this->uid]);
        if ($stmt->rowCount() > 0)
            return true;
        return false;
    }
}
?>
