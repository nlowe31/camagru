<?php

class UserController extends Controller {
    private $user;

    public function __construct() {
        $this->getModel('user');
        $this->getCurrentUser();
    }

    private function getCurrentUser() {
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

    private function loggedIn() {
        if ($this->getCurrentUser() && isset($_SESSION['auth']) && $_SESSION['auth'] === $this->user->uid)
            return TRUE;
        return FALSE;
    }
    
    public function login($error = '') {
        if (isset($_SESSION['user']))
            return $this->loginSuccess();
        $this->displayView('user/login', ['error' => $error]);
    }

    public function logout() {
        unset($this->user);
        unset($_SESSION['auth']);
        unset($_SESSION['user']);
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

    private function loginSuccess() {
        if (!($this->getCurrentUser())) {
            unset($_SESSION['user']);
            return $this->login();            
        }
        if ($this->user->confirmed == 0)
            return $this->unconfirmedEmail();
        $_SESSION['auth'] = $this->user->uid;
        echo "User {$this->user->firstName} {$this->user->lastName} currently logged in.\n";
        // echo "User {$_SESSION['user']->firstName} {$_SESSION['user']->lastName} logged in successfully.\n";
        $this->displayView('user/loginSuccess');
    }
    
    public function signup($error = '') {
        $this->displayView('user/signup', ['error' => $error]);
    }

    public function createUser() {
        if (isset($_POST['Submit'], $_POST['email'], $_POST['firstName'], $_POST['lastName'], $_POST['password'], $_POST['confirm']) && $_POST['Submit'] == 'Sign Up') {
            if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                if ($_POST['password'] === $_POST['confirm']) {
                    if (User::find($_POST['email']) === FALSE) {
                        if ($this->user = User::create($_POST['email'], $_POST['password'], $_POST['firstName'], $_POST['lastName'])) {
                            $_SESSION['user'] = $this->user->uid;
                            return $this->sendConfirmationEmail();
                        }
                        return $this->signup('An unknown error occurred. Please try again later.');
                    }
                    return $this->signup('A user with this email address already exists.');
                }
                return $this->signup('The passwords entered do not match one another.');
            }
            return $this->signup('Invalid email address.');
        }
        return $this->signup('Please ensure all fields have been completed.');
    }

    public function sendConfirmationEmail() {
        if (!($this->getCurrentUser()) || $this->user->confirmed == 1)
            return $this->login();
        $this->user->registration = hash("md5", date(DateTime::W3C));
        $this->user->push();

        $to = htmlspecialchars($this->user->email);
        $subject = 'Camagru: Confirm your email';
        $message = "Hi {$this->user->firstName},<br><br>Please confirm your email address by clicking the link below:<br><br><a href=\"http://localhost:8080/user/confirm/{$this->user->email}/{$this->user->registration}\">Confirm Email</a><br><br>Best,<br>The Camagru Team";
        App::email($to, $subject, $message);
        return $this->unconfirmedEmail();
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
        if (!($this->getCurrentUser()) || $this->user->confirmed == 1)
            return $this->login();
        $this->displayView('user/confirmEmail', ['error' => $error]);
    }

    public function myAccount($error = '') {
        if (!($this->getCurrentUser()))
            return $this->login();
        $this->displayView('user/myAccount', ['user' => $this->user, 'error' => $error]);
    }

    public function changeUser() {
        if (!($this->getCurrentUser()))
            return $this->login();
        if (isset($_POST['Submit']) && $_POST['Submit'] === 'Change Email' && isset($_POST['email'])) {
            if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                if (User::find($_POST['email']) === FALSE) {
                    $this->user->email = htmlspecialchars($_POST['email']);
                    $this->user->confirmed = 0;
                    $this->user->push();
                    return $this->sendConfirmationEmail();
                }
                else
                    return $this->myAccount('A user with this email address already exists.');
            }
            else
                return $this->myAccount('Invalid email address.');
        }
        else if (isset($_POST['Submit']) && $_POST['Submit'] === 'Change Password' && isset($_POST['password'], $_POST['confirm'])) {
            if ($_POST['password'] === $_POST['confirm']) {
                $this->user->setPassword($_POST['password']);
                $this->user->push();
                return $this->myAccount('Password changed successfully.');
            }
            else
                return $this->myAccount('The passwords entered do not match one another.');
        }
        else if (isset($_POST['Submit']) && $_POST['Submit'] === 'Change Name' && isset($_POST['firstName'], $_POST['lastName'])) {
            $this->user->firstName = htmlspecialchars($_POST['firstName']);
            $this->user->lastName = htmlspecialchars($_POST['lastName']);
            $this->user->push();
            return $this->myAccount('Name changed successfully.');
        }
        else if (isset($_POST['Submit']) && $_POST['Submit'] === 'Delete Account') {
            $this->user->delete();
            $this->logout();
            return $this->login('User successfully deleted.');
        }
    }

    public function passwordResetRequest($error = '') {
        $this->displayView('user/passwordResetRequest', ['error' => $error]);
    }

    public function sendResetRequestEmail() {
        if (isset($_POST['Submit'], $_POST['email']) && $_POST['Submit'] === 'Reset Password') {
            if ($this->user = User::find($_POST['email'])) {
                $this->user->registration = hash("md5", date(DateTime::W3C));
                $this->user->push();

                $to = htmlspecialchars($_POST['email']);
                $subject = 'Camagru: Password reset';
                $message = "Hi {$this->user->firstName},<br><br>You can reset your password by clicking the link below:<br><br><a href=\"http://localhost:8080/user/reset/{$this->user->email}/{$this->user->registration}\">Reset Password/a><br><br>Best,<br>The Camagru Team";
                App::email($to, $subject, $message);
                return $this->passwordResetRequest('Check your email for a link to reset your password.');
            }
        }
    }

    public function resetPassword($email, $key) {
        if (isset($email, $key) && ($this->user = User::find($email)) && strcmp($this->user->registration, $key) === 0) {
            $_SESSION['user'] = $this->user->uid;
            return $this->changePassword();
        }
        return $this->passwordReset('An error occurred.');
    }

    private function changePassword() {
        if (!($this->getCurrentUser()))
            return $this->passwordReset('An error occurred.');            
        $this->displayView('user/changePassword', ['error' => $error]);
    }

    public function newPassword() {
        if (!($this->getCurrentUser()))
            return $this->getCurrentUser('An error occurred.');
        if (isset($_POST['Submit']) && $_POST['Submit'] === 'Change Password' && isset($_POST['password'], $_POST['confirm'])) {
            if ($_POST['password'] === $_POST['confirm']) {
                $this->user->setPassword($_POST['password']);
                $this->user->push();
                return $this->loginSuccess('Password changed successfully.');
            }
            else
                return $this->changePassword('The passwords entered do not match one another.');
        }
    }
}
?>