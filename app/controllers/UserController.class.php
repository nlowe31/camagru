<?php

class UserController extends Controller {
    private $user;

    public function __construct() {
        $this->getModel('user');
    }
    
    public function login() {
        $this->displayView('user/login');
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
        $_SESSION['user'] = $this->user->uid;
        echo "User {$this->user->firstName} {$this->user->lastName} currently logged in.\n";
        // echo "User {$_SESSION['user']->firstName} {$_SESSION['user']->lastName} logged in successfully.\n";
        $this->displayView('user/loginSuccess.php');
    }
    
    private function loginFailure() {
        echo "loginFailure\n";
    }

    public function unconfirmedEmail() {
        echo "Email confirmation needed\n";
    }

    public function signup($error = NULL) {
        $this->displayView('user/signup');
    }

    public function createUser() {
        if (isset($_POST['Login']) && $_POST['Login'] == 'Login' && isset($_POST['email'], $_POST['firstName'], $_POST['lastName'], $_POST['password'], $_POST['confirm'])) {
            if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                if ($_POST['password'] === $_POST['confirm']) {
                    if ($this->user = User::create($_POST['email'], $_POST['password'], $_POST['firstName'], $_POST['lastName'])) {
                        return $this->unconfirmedEmail();
                    }
                    else
                        return $this->signup("An unknown error occurred. Please try again later.");
                }
                else
                    return $this->signup("Invalid email address.");
            }
            else
                return $this->signup("Invalid email address.");
        }
        return $this->signup("Please ensure all fields have been completed.");
    }

    public function myAccount() {}

    public function changeUser() {}
}
?>