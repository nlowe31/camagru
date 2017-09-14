<?php

class UserController {
    public function __construct() {
        echo 'UserController';
    }
    
    public function login() {
        require_once('views/login.php');
    }

    public function auth() {
        if (isset($_POST['Login']) && $_POST['Login'] == 'Login' && isset($_POST['email']) && isset($_POST['password'])) {
            if ($user = User::get($_POST['email'])) {
                if ($user->authenticate($_POST['password']) === TRUE) {
                    $_SESSION['user'] = $user;
                    if ($user->confirmed == 1)
                        return $this->loginSuccess();
                    return $this->confirmEmail();
                }
            return $this->loginFailure();
            }
        }
        return $this->loginSuccess();
    }

    private function loginSuccess() {
        echo "loginSuccess\n";        
        echo "User {$_SESSION['user']->firstName} {$_SESSION['user']->lastName} logged in successfully.\n";
        // require_once('views/loginSuccess.php');
    }
    
    private function loginFailure() {
        echo "loginFailure\n";
    }

    public function confirmEmail() {}
    
    public function signup() {}

    public function createUser() {}    
}
?>