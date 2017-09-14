<?php
$loginForm = new Form('action="?controller=user&action=auth" method="POST"');
$loginForm->text('email');
$loginForm->password('password');
$loginForm->submit('Login', NULL, NULL, 'Login');
$loginForm->put();
?>