<?php
require_once(ROOT_DIR."/html/movie/DBConnect.php");

class Movie implements DBConnect {
	private $_pdo;

	function __construct() {
		$this->_pdo = $this->dbConnect();
		if ($this->_pdo == false) exit("データベースに接続できませんでした");
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
		$file = fopen("DataBaseConfig.file", "r");
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

	function getTitle($keyword) {
		$query = "SELECT * FROM video ";
		$query.= " WHERE title like :keyword";
		$stmt = $this->_pdo->prepare($query);
		if ($stmt == false) return false;
		$stmt->bindValue(":keyword", $keyword, PDO::PARAM_STR);
		$result = $stmt->execute();
		if ($result == false) return false;
		$data_list = $stmt->fetchAll();
		if ($data_list == false) return false;
		if (stripos($data_list[0]["thumbnail"],"/test/") != false) {
			$data_list[0]["thumbnail"] = str_replace("/test/", "/movie/", $data_list[0]["thumbnail"]);
			$data_list[0]["url"] = str_replace("/test/", "/movie/", $data_list[0]["url"]);
		}
		return $data_list;
	}

	function getRanking() {
		$query = "SELECT * FROM video ";
		$query.= " ORDER BY count DESC";
		$stmt = $this->_pdo->prepare($query);
		if ($stmt == false) return false;
		$result = $stmt->execute();
		if ($result == false) return false;
		$data_list = $stmt->fetchAll();
		if ($data_list == false) return false;
		if (stripos($data_list[0]["thumbnail"],"/test/") != false) {
			$data_list[0]["thumbnail"] = str_replace("/test/", "/movie/", $data_list[0]["thumbnail"]);
			$data_list[0]["url"] = str_replace("/test/", "/movie/", $data_list[0]["url"]);
		}
		return $data_list;
	}

	function getTag($keyword) {
		$query = "SELECT * FROM video ";
		$query.="WHERE tag like :keyword";
		$stmt = $this->_pdo->prepare($query);
		if ($stmt == false) return false;
		$stmt->bindValue(":keyword", $keyword, PDO::PARAM_STR);
		$result = $stmt->execute();
		if ($result == false) return false;
		$data_list = $stmt->fetchAll();
		if ($data_list == false) return false;
		if (stripos($data_list[0]["thumbnail"],"/test/") != false) {
			$data_list[0]["thumbnail"] = str_replace("/test/", "/movie/", $data_list[0]["thumbnail"]);
			$data_list[0]["url"] = str_replace("/test/", "/movie/", $data_list[0]["url"]);
		}
		return $data_list;
	}

	function getComment($id) {
		$query = "SELECT * from Comment ";
		$query.= "WHERE video_id=:id";
		$stmt  = $this->_pdo->prepare($query);
		if ($stmt == false) return false;
		$stmt->bindValue(":id", $id, PDO::PARAM_INT);
		$result = $stmt->execute();
		if ($result == false) return false;
		$data_list = $stmt->fetchAll();
		if ($data_list == false) return false;
		return $data_list;
	}

	function addTag($tag, $video_id) {
		$query = "INSERT INTO video(tag) ";
		$query.="VALUES(:tag) WHERE video_id=:video_id";
		$stmt = $this->_pdo->prepare($query);
		if ($stmt == false) return false;
		$stmt->bindValue(":tag", $tag, PDO::PARAM_STR);
		$stmt->bindValue(":video_id",$video_id,PDO::PARAM_INT);
		$result = $stmt->execute();
		if ($result == false) return false;
		return true;
	}

	function addMovie($data) {
		$query  = "INSERT INTO video(name,title,tag,url,usr,thumbnail,count) ";
		$query .= "VALUES(:name,:title,:tag,:url,:usr,:thumbnail,:count)";
		$stmt = $this->_pdo->prepare($query);
		if ($stmt == false) return false;
		$stmt->bindValue(":usr", $data["usr"], PDO::PARAM_STR);
		$stmt->bindValue(":name", $data["name"], PDO::PARAM_STR);
		$stmt->bindValue(":title", $data["title"], PDO::PARAM_STR);
		$stmt->bindValue(":tag", $data["tag"], PDO::PARAM_STR);
		$stmt->bindValue(":url", $data["url"], PDO::PARAM_STR);
		$stmt->bindValue(":thumbnail",$data["thumbnail"],PDO::PARAM_STR);
		$stmt->bindValue(":count",$data["count"],PDO::PARAM_INT);
		$result = $stmt->execute();
		if ($result == false) return false;
		return true;
	}

	function addComment($id, $data, $usr) {
		$query = "INSERT INTO Comment(video_id,com,usr) ";
		$query.= "VALUES(:video_id,:comment,:usr)";
		$stmt  = $this->_pdo->prepare($query);
		if ($stmt == false) return false;
		$stmt->bindValue(":video_id", $id, PDO::PARAM_INT);
		$stmt->bindValue(":comment", $data, PDO::PARAM_STR);
		$stmt->bindValue(":usr", $usr, PDO::PARAM_STR);
		$result = $stmt->execute();
		if ($result == false) return false;
		return true;
	}	

	function updateViewCount($count, $video_id) {
		$query = "UPDATE video SET count=:count ";
		$query.="WHERE video_id=:video_id";
		$stmt = $this->_pdo->prepare($query);
		if ($stmt == false) return false;
		$stmt->bindValue(":count", $count, PDO::PARAM_INT);
		$stmt->bindValue(":video_id", $video_id, PDO::PARAM_INT);
		$result = $stmt->execute();
		if ($result == false) return false;
		return true;
	}

	//セキュリティ
	function format($str) {
		$str = htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
		return $str;
	}
}
