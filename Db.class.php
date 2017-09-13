<?php
class Db {
	private static $instance = NULL;

	private function __construct() {}

	private function __clone() {}

	public static function get() {
		if (!isset(self::$instance)) {
			$config = parse_ini_file('dbConfig.ini');
			$options = [
			    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
			    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			    PDO::ATTR_EMULATE_PREPARES   => false,
			];
			try {
				self::$instance = new PDO("mysql:unix_socket=/Applications/MAMP/tmp/mysql/mysql.sock;dbname={$config['dbName']}", $config['username'], $config['password'], $options);
				// self::$instance = new PDO("mysql:host={$config['host']};dbname={$config['dbName']}", $config['username'], $config['password'], $options);
			} catch (PDOException $e) {
				die($e->getMessage());
			}
		}
		return self::$instance;
	}

	public static function exec($sql, $values) {
		self::get();
		$stmt = self::$instance->prepare($stmt);
		$count = $stmt->execute($values);
		return $count;
	}

	public static function insert($sql, $values) {
		self::get();
		$stmt = self::$instance->prepare("$sql");
		if ($stmt->execute($values))
			return self::$instance->lastInsertId();
		return FALSE;
	}
}

?>
