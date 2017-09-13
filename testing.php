<?php
error_reporting( E_ALL );

include('Db.class.php');

$db = Db::get();

// echo (Db::insert('INSERT INTO users (email, firstName) VALUES (?, ?)', ['nlowe31@gmail.com', 'Nate']));
echo (Db::insert('UPDATE users SET firstName=? WHERE email=?', ['YES', 'nlowe31@gmail.com']) . "\n");

?>