<?php

require_once(ROOT_DIR."/html/movie/DBConnect.php");
class Usr implements DBConnect {
	private $_pdo;

	function __construct() {
		$this->_pdo = $this->dbConnect();
		if ($this->_pdo == false) exit("データベースにアクセスできません");
	}

	function dbConnect() {
		try {
			$config = $this->loadConfig();
			$dsn = $config[0];
			$usr = $config[1];
			$passwd = $config[2];
			$pdo = new PDO($dsn, $usr, $passwd);
		} catch (PDOException $e) {
			return false;
		}
		return $pdo;
	}

	private function loadConfig() {
		$file = fopen('DataBaseConfig.file', 'r');
		if ($file == false) return false;
		$config = null;
		$count = 0;
		while (!feof($file)){
			$config[$count] = fgets($file);
			$config[$count] = trim($config[$count]);
			$count++;
		}
		return $config;
	}

	function getUser() {
		$query = "SELECT * FROM person";
		$stmt = $this->_pdo->prepare($query);
		if ($stmt == false) return false;
		$result = $stmt->execute();
		if ($result == false) return false;
		$data_list = $stmt->fetchAll();
		if ($data_list == false) return false;
		return $data_list;
	}

	function addUser($usr) {
		$query = "INSERT INTO person(name,password) ";
		$query.= "VALUES(:name,:password)";
		$stmt = $this->_pdo->prepare($query);
		if ($stmt == false) return false;
		$stmt->bindValue(":name",$usr["name"],PDO::PARAM_STR);
		$stmt->bindValue(":password",sha1($usr["password"]),PDO::PARAM_STR);
		$result = $stmt->execute();
		if ($result == false) return false;
		return true;
	}

	function isAuthorities($usr_list, $name, $pass) {
		if ($usr_list) {
			foreach ($usr_list as $usr) {
				if ($usr["name"] == $name && 
						$usr["password"] == sha1($pass)) return true;
			}
		}
		return false;
	}
}
