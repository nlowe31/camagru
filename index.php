<?php

error_reporting(E_ALL);

session_start();
date_default_timezone_set("Europe/Paris");
require_once('app/init.php');

define('PORT', '8080');

$app = new App;

?>