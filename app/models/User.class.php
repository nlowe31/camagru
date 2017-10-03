<?php

class User {
    public $uid;
    public $username;
    public $email;
    private $password;
    public $firstName;
    public $lastName;
    public $created;
    public $registration;
    public $confirmed;

    public function __construct() {}

    public static function create($username, $email, $password, $firstName, $lastName) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        return self::get(Db::insert('INSERT INTO users (username, email, password, firstName, lastName) VALUES (?, ?, ?, ?, ?)', [$username, $email, $password, $firstName, $lastName]));
    }

    public static function get($uid) {
        return Db::select_object('SELECT * FROM users WHERE uid=?', [$uid], 'User');
    }

    public static function findByEmail($email) {
        return Db::select_object('SELECT * FROM users WHERE email=?', [$email], 'User');
    }

    public static function findByUsername($username) {
        return Db::select_object('SELECT * FROM users WHERE username=?', [$username], 'User');        
    }

    public function authenticate($password) {
        return password_verify($password, $this->password);
    }

    public function setPassword($password) {
        $this->password = password_hash($password, PASSWORD_DEFAULT);        
    }

    public function push() {
        $count = Db::update('UPDATE users SET username=?, email=?, password=?, firstName=?, lastName=?, confirmed=?, registration=? WHERE uid=?', [$this->username, $this->email, $this->password, $this->firstName, $this->lastName, $this->confirmed, $this->registration, $this->uid]);
        if ($count > 0)
            return TRUE;
        return FALSE;
    }

    public function delete() {
        $count = Db::update('DELETE FROM users WHERE uid=?', [$this->uid]);
        if ($count > 0)
            return TRUE;
        return FALSE;
    }
}
?>
