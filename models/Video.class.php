<?php
require_once("/var/www/html/movie/models/DbConnect.class.php");

class Video extends DbConnect {
	public function getTitle($keyword) {
	    if (is_array($keyword) || empty($keyword)) return false;
    	    $sql = "SELECT * FROM video WHERE title like :keyword";
	    $bind_value = array(":keyword" => array("value" => $keyword, "option" => PDO::PARAM_STR));
	    $data_list = parent::query($sql, $bind_value);
	    return $data_list;
	}

	public function getTag($keyword) {
	    if (is_array($keyword) || empty($keyword)) return false;
	    $sql = "SELECT * FROM video WHERE tag like :keyword";
	    $bind_value = array(":keyword"=> array("value" => $keyword, "option" => PDO::PARAM_STR));
	    $data_list = parent::query($sql, $bind_value);
	    return $data_list;
	}

	public function getVideoInfo($id) {
	    if (Judge::isNaturalNumber($id) === false) return false;
	    $sql = "SELECT * FROM video WHERE video_id = :id";
	    $bind_value = array(":id" => array("value" => $id, "option" => PDO::PARAM_INT));
	    $data_list = parent::query($sql, $bind_value);
	    return $data_list;
	}

	public function addTag($tag, $video_id) {
	    if (is_array($tag) || empty($tag)) return false;
	    $sql = "INSERT INTO video(tag) VALUES(:tag) WHERE video_id=:video_id";
	    if (Judge::isNaturalNumber($video_id) === false) return false;
	    $bind_value = array(":tag" => array("value" => $tag, "option" => PDO::PARAM_STR),
	                        ":video_id" => array("value" => $video_id, "option" => PDO::PARAM_INT));
	    $result = parent::query($sql, $bind_value);
	    return $result;
	}

	public function contribute($data) {
	    if (is_array($data) === false || empty($data)) return false;
	    if (in_array(NULL, $data)) return false;
	    if (Judge::isNaturalNumber($data["count"]) === false) return false;
	    $sql  = "INSERT INTO video(name, title, tag, url, usr, thumbnail, count) ";
	    $sql .= "VALUES(:name, :title,:tag, :url,:usr, :thumbnail, :count)";
	    $bind_value = array(":usr" => array("value" => $data["usr"], "option" => PDO::PARAM_STR),
	                        ":name"=> array("value" => $data["name"], "option" =>PDO::PARAM_STR),
	                        ":title" => array("value" => $data["title"], "option" => PDO::PARAM_STR),
	                        ":tag" => array("value" => $data["tag"], "option" => PDO::PARAM_STR),
	                        ":url" => array("value" => $data["url"], "option" => PDO::PARAM_STR),
	                        ":thumbnail" => array("value" => $data["thumbnail"], "option" => PDO::PARAM_STR),
	                        ":count" => array("value" => $data["count"], "option" => PDO::PARAM_INT));
	    $result = parent::query($sql, $bind_value);
	    return $result;
	}
}
