<?php

class UserController {
    public function login() {
        
    }

    public function auth() {
        if (isset($_POST['email']) && isset($_POST['password'])) {
            if ($user = User::get($_POST['email'])) {
                if ($user->authenticate($_POST['password']) === TRUE) {
                    $_SESSION['user'] = $user;
                }
            }
        }
    }

    private function loginSuccess() {}
    
    private function loginFailure() {}

    public function confirmEmail() {}
    
    public function signup() {}

    public function createUser() {}    
}
?>