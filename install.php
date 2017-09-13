<?php
require_once('Db.class.php');

echo "Reading configuration...\n";

$config = parse_ini_file('dbConfig.ini');

echo "Connecting to database...\n";

$options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $db = new PDO("mysql:host={$config['host']};unix_socket=/Applications/MAMP/tmp/mysql/mysql.sock;charset=utf8mb4", $config['username'], $config['password'], $options);
} catch (PDOException $e) {
    die($e->getMessage());
}

echo "Connection successful.\n";

$sql = file_get_contents('install.sql');
try {
    $db->exec($sql);
}
catch (PDOException $e) {
    die($e->getMessage());
}

?>