<?php
class Db {
	private static $instance = NULL;

	private function __construct() {}

	private function __clone() {}

	private function __wakeup() {}		

	public static function get() {
		if (!isset(self::$instance)) {
			$config = parse_ini_file('dbConfig.ini');
			$options = [
			    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
			    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			    PDO::ATTR_EMULATE_PREPARES   => false,
			];
			try {
				self::$instance = new PDO("mysql:unix_socket=/Applications/MAMP/tmp/mysql/mysql.sock;dbname={$config['dbName']};charset=utf8mb4", $config['username'], $config['password'], $options);
				// self::$instance = new PDO("mysql:host={$config['host']};dbname={$config['dbName']};charset=utf8mb4", $config['username'], $config['password'], $options);
			} catch (PDOException $e) {
				die($e->getMessage());
			}
		}
		return self::$instance;
	}

	public static function prepare($sql, $values) {
		self::get();
		$stmt = self::$instance->prepare($sql);
		$stmt->execute($values);
		return $stmt;
	}

	public static function insert($sql, $values) {
		$stmt = self::prepare($sql, $values);
		return self::$instance->lastInsertId();
	}

	public static function update($sql, $values) {
		if ($stmt = self::prepare($sql, $values))
			return $stmt->rowCount();
		return FALSE;
	}

	public static function select($sql, $values) {
		return self::prepare($sql, $values);
	}

	public static function select_object($sql, $values, $object) {
		if ($stmt = self::prepare($sql, $values))
            return $stmt->fetchObject($object);
		return FALSE;
	}

	public static function select_one($sql, $values) {
		if ($stmt = self::prepare($sql, $values))
			return $stmt->fetch();
		return FALSE;	
	}

	public static function select_all($table) {
		self::get();
		$stmt = self::$instance->query("SELECT * FROM $table");
		return $stmt;
	}

}

?>
