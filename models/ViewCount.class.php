<?php

class ViewCount {
	private  $_pdo;

	public function __construct($connect) {
		$this->_pdo = $connect->_pdo;
		if ($this->_pdo === false) return false;
	}

	public function getRanking() {
		$query = "SELECT * FROM video ";
		$query.= "ORDER BY count DESC";
		$stmt = $this->_pdo->prepare($query);
		if ($stmt === false) return false;
		$result = $stmt->execute();
		if ($result === false) return false;
		$data_list = $stmt->fetchAll();
		if ($data_list === false) return false;
		return $data_list;
	}

	public function update($count, $video_id) {
		$query = "UPDATE video SET count = :count ";
		$query.= "WHERE video_id = :video_id";
		$stmt = $this->_pdo->prepare($query);
		if ($stmt === false) return false;
		$stmt->bindValue(":count", $count, PDO::PARAM_INT);
		$stmt->bindValue(":video_id", $video_id, PDO::PARAM_INT);
		$result = $stmt->execute();
		if ($result === false) return false;
		return true;
	}
}
