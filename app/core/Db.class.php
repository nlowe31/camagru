<?php
class Db {
	private static $instance = NULL;

	private function __construct() {}

	private function __clone() {}

	private function __wakeup() {}		

	public static function get() {
		if (!isset(self::$instance)) {
			$options = [
			    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
			    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			    PDO::ATTR_EMULATE_PREPARES   => false,
			];
			try {
				require('config/database.php');
				self::$instance = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, $options);
			} catch (PDOException $e) {
				echo "Error connecting to database.\n";
				die($e->getMessage());
			}
		}
		return self::$instance;
	}

    public static function query($query) {
        self::get();
        $stmt = self::$instance->query($query);
        return $stmt;
    }

	public static function prepare($sql, $values) {
		self::get();
		$stmt = self::$instance->prepare($sql);
		$stmt->execute($values);
		return $stmt;
	}

	public static function insert($sql, $values) {
		self::get();
		self::prepare($sql, $values);
		return self::$instance->lastInsertId();
	}

	public static function update($sql, $values) {
		self::get();
		if ($stmt = self::prepare($sql, $values))
			return $stmt->rowCount();
		return FALSE;
	}

	public static function select($sql, $values) {
		self::get();
		return self::prepare($sql, $values);
	}

    public static function select_one($sql, $values) {
        self::get();
        if ($stmt = self::prepare($sql, $values))
            return $stmt->fetch();
        return FALSE;
    }

    public static function select_one_object($sql, $values, $object) {
        self::get();
        if ($stmt = self::prepare($sql, $values))
            return $stmt->fetchObject($object);
        return FALSE;
    }

    public static function select_all($sql, $values) {
        self::get();
        if ($stmt = self::prepare($sql, $values))
            return $stmt->fetchAll();
        return FALSE;
    }

    public static function select_all_object($sql, $values, $object) {
        self::get();
        if ($stmt = self::prepare($sql, $values))
            return $stmt->fetchAll(PDO::FETCH_CLASS, $object);
        return FALSE;
    }
}

?>
