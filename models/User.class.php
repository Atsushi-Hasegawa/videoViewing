<?php

class User {
	private $_pdo;

	public function __construct($connect) {
		$this->_pdo = $connect->_pdo;
		if ($this->_pdo === false) return false;
	}

	public function getUser() {
		$query = "SELECT * FROM person";
		$stmt = $this->_pdo->prepare($query);
		if ($stmt === false) return false;
		$result = $stmt->execute();
		if ($result === false) return false;
		$data_list = $stmt->fetchAll();
		if ($data_list === false) return false;
		return $data_list;
	}

	public function addUser($usr) {
		$query = "INSERT INTO person(name, password) ";
		$query.= "VALUES(:name, :password)";
		$stmt = $this->_pdo->prepare($query);
		if ($stmt === false) return false;
		$stmt->bindValue(":name", $usr["name"], PDO::PARAM_STR);
		$stmt->bindValue(":password", sha1($usr["password"]), PDO::PARAM_STR);
		$result = $stmt->execute();
		if ($result === false) return false;
		return true;
	}

	public function isAuthorities($usr_list, $name, $pass) {
		if ($usr_list) {
			foreach ($usr_list as $usr) {
				if ($usr["name"] === $name && $usr["password"] === sha1($pass)) return true;
			}
		}
		return false;
	}
}
