<?php

class UserController {
    public $user;
    
    public function __construct() {
        echo 'UserController';
        if (isset($_SESSION['user'])) {
            if (!($this->user = User::get($_SESSION['user'])))
                unset($this->user);
        }
    }
    
    public function login() {
        require_once('views/login.php');
    }

    public function auth() {
        if (isset($_POST['Login']) && $_POST['Login'] == 'Login' && isset($_POST['email']) && isset($_POST['password'])) {
            if ($this->user = User::find($_POST['email'])) {
                if ($this->user->authenticate($_POST['password']) === TRUE) {
                    if ($this->user->confirmed == 1)
                        return $this->loginSuccess();
                    return $this->unconfirmedEmail();
                }
            return $this->loginFailure();
            }
        }
        return $this->login();
    }

    public function loginSuccess() {
        echo "loginSuccess\n";
        $_SESSION['user'] = $this->user->uid;
        echo "User {$this->user->firstName} {$this->user->lastName} currently logged in.\n";
        // echo "User {$_SESSION['user']->firstName} {$_SESSION['user']->lastName} logged in successfully.\n";
        require_once('views/loginSuccess.php');
    }
    
    private function loginFailure() {
        echo "loginFailure\n";
    }

    public function unconfirmedEmail() {
        echo "Email confirmation needed\n";
    }
    
    public function confirmedEmail() {}

    public function signup() {}

    public function createUser() {}

    public function myAccount() {}

    public function changeUser() {}
}
?>