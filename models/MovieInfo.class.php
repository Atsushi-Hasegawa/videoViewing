<?php

class MovieInfo {
	private $_pdo;

	public function __construct($connect) {
		$this->_pdo = $connect->_pdo;
		if($this->_pdo === false) return false;
	}

	public function addTag($tag, $video_id) {
		$query = "INSERT INTO video(tag) ";
		$query.= "VALUES(:tag) WHERE video_id=:video_id";
		$stmt = $this->_pdo->prepare($query);
		if ($stmt === false) return false;
		$stmt->bindValue(":tag", $tag, PDO::PARAM_STR);
		$stmt->bindValue(":video_id", $video_id, PDO::PARAM_INT);
		$result = $stmt->execute();
		if ($result === false) return false;
		return true;
	}

	public function addMovie($data) {
		$query  = "INSERT INTO video(name, title, tag, url, usr, thumbnail, count) ";
		$query .= "VALUES(:name, :title,:tag, :url,:usr, :thumbnail, :count)";
		$stmt = $this->_pdo->prepare($query);
		if ($stmt === false) return false;
		$stmt->bindValue(":usr", $data["usr"], PDO::PARAM_STR);
		$stmt->bindValue(":name", $data["name"], PDO::PARAM_STR);
		$stmt->bindValue(":title", $data["title"], PDO::PARAM_STR);
		$stmt->bindValue(":tag", $data["tag"], PDO::PARAM_STR);
		$stmt->bindValue(":url", $data["url"], PDO::PARAM_STR);
		$stmt->bindValue(":thumbnail", $data["thumbnail"],PDO::PARAM_STR);
		$stmt->bindValue(":count", $data["count"], PDO::PARAM_INT);
		$result = $stmt->execute();
		if ($result === false) return false;
		return true;
	}

	public function addComment($id, $data, $usr) {
		$query = "INSERT INTO Comment(video_id, com, usr) ";
		$query.= "VALUES(:video_id, :comment, :usr)";
		$stmt  = $this->_pdo->prepare($query);
		if ($stmt === false) return false;
		$stmt->bindValue(":video_id", $id, PDO::PARAM_INT);
		$stmt->bindValue(":comment", $data, PDO::PARAM_STR);
		$stmt->bindValue(":usr", $usr, PDO::PARAM_STR);
		$result = $stmt->execute();
		if ($result === false) return false;
		return true;
	}
}
