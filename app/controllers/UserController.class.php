<?php

class UserController extends Controller {
    private $user;

    public function __construct() {
        $this->getModel('user');
    }

    private function currentUser() {
        if (isset($this->user))
            return TRUE;
        else if (!isset($_SESSION['user'])) {
            return FALSE;
        }
        else if (!($this->user = User::get($_SESSION['user']))) {
            unset($_SESSION['user']);
            return FALSE;
        }
        return TRUE;
    }
    
    public function login($error = '') {
        if (isset($_SESSION['user']))
            return $this->loginSuccess();
        $this->displayView('user/login');
    }

    public function auth() {
        if (isset($_POST['Login'], $_POST['email'], $_POST['password']) && $_POST['Login'] == 'Login') {
            if ($this->user = User::find($_POST['email'])) {
                if ($this->user->authenticate($_POST['password']) === TRUE) {
                    $_SESSION['user'] = $this->user->uid;
                    return $this->loginSuccess();
                }
            return $this->login("Invalid username/password combination.");
            }
        }
        return $this->login();
    }

    public function loginSuccess() {
        if (!isset($_SESSION['user'])) {
            return $this->login();
        }
        if (!isset($this->user)) {
            if (!($this->user = User::get($_SESSION['user']))) {
                unset($_SESSION['user']);
                return $this->login();
            }
        }
        if ($this->user->confirmed == 0)
            return $this->unconfirmedEmail();
        $_SESSION['auth'] = $this->user->uid;
        echo "User {$this->user->firstName} {$this->user->lastName} currently logged in.\n";
        // echo "User {$_SESSION['user']->firstName} {$_SESSION['user']->lastName} logged in successfully.\n";
        $this->displayView('user/loginSuccess.php');
    }
    
    public function signup($error = '') {
        $this->displayView('user/signup');
    }

    public function createUser() {
        if (isset($_POST['Login'], $_POST['email'], $_POST['firstName'], $_POST['lastName'], $_POST['password'], $_POST['confirm']) && $_POST['Login'] == 'Login') {
            if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                if ($_POST['password'] === $_POST['confirm']) {
                    if (User::find($_POST['Email']) === FALSE) {
                        if ($this->user = User::create($_POST['email'], $_POST['password'], $_POST['firstName'], $_POST['lastName'])) {
                            $_SESSION['user'] = $this->user->uid;
                            return $this->sendConfirmationEmail();
                        }
                        else
                            return $this->signup('An unknown error occurred. Please try again later.');
                    }
                    else
                        return $this->signup('A user with this email address already exists.');
                }
                else
                    return $this->signup('The passwords entered do not match one another.');
            }
            else
                return $this->signup('Invalid email address.');
        }
        return $this->signup('Please ensure all fields have been completed.');
    }

    public function sendConfirmationEmail($email) {
        currentUser();
        $this->user->registration = hash("md5", date(DateTime::W3C));
        // mail($this->user->email, "Please confirm your email", "")
        // user/confirm/$this->user->email/$this->user->registration
        $this->user->push();
        return $this->user->unconfirmedEmail();
    }

    public function confirm($email, $key) {
        if (isset($email, $key) && ($this->user = User::find($email))) {
            if (strcmp($this->user->registration, $key) === 0) {
                $this->user->confirmed = 1;
                $this->user->push();
                return $this->login('Email successfully confirmed, please sign in.');
            }
            return $this->unconfirmedEmail('Confirmation link expired.');
        }
        return $this->login('An error occurred. Please sign in.');
    }

    public function unconfirmedEmail($error = '') {
        echo "Email confirmation needed\n";
    }

    public function myAccount() {}

    public function changeUser() {}
}
?>