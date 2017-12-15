<html>
<?php
require_once ('database.php');

echo "Connecting to database...\n<br>";

$options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, $options);
    echo "Connection successful.\n<br>";
    $db->exec('DROP DATABASE camagru');
    echo "Previous data removed successfully.\n<br>";
} catch (PDOException $e) {
    try {
        $db = new PDO('mysql:host=localhost;', $DB_USER, $DB_PASSWORD, $options);
        echo "Connection successful.\n<br>";
        echo "No previous data detected.\n<br>";
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}

try {
    $sql = file_get_contents('setup.sql');
    $db->exec($sql);
    echo "Database created successfully.\n<br>";
} catch (PDOException $e) {
    die($e->getMessage());
}

?>
</html>