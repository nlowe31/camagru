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
				self::$instance = new PDO("mysql:host={$config['host']};dbname={$config['dbName']}", $config['username'], $config['password'], $options);
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

	public static function insert($table, $attributes, $values) {
		self::get();
		$len = sizeof($attributes);
		if (len !== sizeof($values))
			return false;
		for ($i = 1; $i < $len; $i++) {
			$repeat .= '?, ';
		}
		$repeat .= '?';
		echo "INSERT INTO $table (" . $repeat . ") VALUES (" . $repeat . ")";
		// $stmt = self::$instance->prepare("INSERT INTO $table (" . $repeat . ") VALUES (" . $repeat . ")");
		// if ($stmt->execute(array_merge($attributes, $values)))
		// 	return self::$instance->lastInsertId;
		// return FALSE;
	}
}

?>
