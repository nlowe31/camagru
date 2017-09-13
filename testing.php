<?php
error_reporting( E_ALL );

include('Db.class.php');
include('User.class.php');

$db = Db::get();

// echo (Db::insert('INSERT INTO users (email, firstName) VALUES (?, ?)', ['nlowe31@gmail.com', 'Nate']));
// echo (Db::insert('UPDATE users SET firstName=? WHERE email=?', ['YES', 'nlowe31@gmail.com']) . "\n");
// print_r(User::create('aidz', 'lol', 'Yes', 'No'));
// $current = User::find('aidzz');
// echo $current->firstName . "\n";
// $current->firstName = 'yes';
// echo $current->firstName . "\n";
// echo $current->update() . "\n";
// print_r(User::get($current->uid));

print_r(User::create('nate@gmail.com', 'lolol', 'Nate', 'Lowe'));
$current = User::find('nate@gmail.com');
print_r($current->authenticate('lolol'));

?>