<?php
error_reporting( E_ALL );

include('Db.class.php');

$db = Db::get();

Db::insert('users', ['email', 'firstName'], ['nlowe31@gmail.com', 'Nate']);

?>