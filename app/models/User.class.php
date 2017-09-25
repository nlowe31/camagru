<?php

class User {
    public $uid;
    public $email;
    protected $password;
    public $firstName;
    public $lastName;
    public $created;
    public $registration;
    public $confirmed;

    public function __construct() {}

    public static function create($email, $password, $firstName, $lastName) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        return self::get(Db::insert('INSERT INTO users (email, password, firstName, lastName) VALUES (?, ?, ?, ?)', [$email, $password, $firstName, $lastName]));
    }

    public static function get($uid) {
        return Db::select_object('SELECT * FROM users WHERE uid=?', [$uid], 'User');
    }

    public static function find($email) {
        return Db::select_object('SELECT * FROM users WHERE email=?', [$email], 'User');
    }

    public function authenticate($password) {
        return password_verify($password, $this->password);
    }

    public function setPassword($password) {
        $this->password = password_hash($password, PASSWORD_DEFAULT);        
    }

    public function push() {
        $count = Db::update('UPDATE users SET email=?, password=?, firstName=?, lastName=?, confirmed=?, registration=? WHERE uid=?', [$this->email, $this->password, $this->firstName, $this->lastName, $this->confirmed, $this->registration, $this->uid]);
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
