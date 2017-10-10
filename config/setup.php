<?php
require_once ('database.php');

echo "Connecting to database...\n";

$options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, $options);
} catch (PDOException $e) {
    die($e->getMessage());
}

echo "Connection successful.\n";

$sql = file_get_contents('setup.sql');
try {
    $db->exec($sql);
    echo "Database created successfully.\n";
}
catch (PDOException $e) {
    die($e->getMessage());
}

?>