<?php
require_once('app/core/Db.class.php');

echo "Reading configuration...\n";

$config = parse_ini_file('app/core/dbConfig.ini');

echo "Connecting to database...\n";

$options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $db = new PDO("mysql:host={$config['host']};port={$config['port']};charset={$config['charset']};", $config['username'], $config['password'], $options);
} catch (PDOException $e) {
    die($e->getMessage());
}

echo "Connection successful.\n";

$sql = file_get_contents('install.sql');
try {
    $db->exec($sql);
    echo "Database created successfully.\n";
}
catch (PDOException $e) {
    die($e->getMessage());
}

?>