<?php

class DbConnect {
	public $_pdo;

	public function __construct() {
		$this->_pdo = $this->dbConnect();
	}

	private function dbConnect() {
		try {
			$config = $this->loadConfig();
			$pdo = new PDO($config[0], $config[1], $config[2]);
		} catch (PDOException $e) {
			return false;
		}
		return $pdo;
	}

	private  function loadConfig() {
		$file = @file_get_contents("/var/www/html/movie/config/DataBaseConfig.file");
		if($file === false) return false;
		$config = array();
		$config = explode(" ", $file);
		if(count($config) !== 3) $config = array("", "", "");
		else $config[2] = trim($config[2]);
		return $config;
	}
}
