<?php

class SearchMovie {
	private $_pdo;

	public function __construct($connect) {
		$this->_pdo = $connect->_pdo;
		if ($this->_pdo === false) return false;
	}

	public function getTitle($keyword) {
		$query = "SELECT * FROM video ";
		$query.= "WHERE title like :keyword";
		$stmt = $this->_pdo->prepare($query);
		if ($stmt === false) return false;
		$stmt->bindValue(":keyword", $keyword, PDO::PARAM_STR);
		$result = $stmt->execute();
		if ($result === false) return false;
		$data_list = $stmt->fetchAll();
		if ($data_list === false) return false;
		return $data_list;
	}

	public function getTag($keyword) {
		$query = "SELECT * FROM video ";
		$query.= "WHERE tag like :keyword";
		$stmt = $this->_pdo->prepare($query);
		if ($stmt === false) return false;
		$stmt->bindValue(":keyword", $keyword, PDO::PARAM_STR);
		$result = $stmt->execute();
		if ($result === false) return false;
		$data_list = $stmt->fetchAll();
		if ($data_list === false) return false;
		return $data_list;
	}

	public function getComment($id) {
		$query = "SELECT * from Comment ";
		$query.= "WHERE video_id = :id";
		$stmt  = $this->_pdo->prepare($query);
		if ($stmt === false) return false;
		$stmt->bindValue(":id", $id, PDO::PARAM_INT);
		$result = $stmt->execute();
		if ($result === false) return false;
		$data_list = $stmt->fetchAll();
		if ($data_list === false) return false;
		return $data_list;
	}
}
