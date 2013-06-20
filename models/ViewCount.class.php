<?php
require_once("/var/www/html/movie/models/DbConnect.class.php");

class ViewCount extends DbConnect {
	public function getRanking() {
	    $sql = "SELECT * FROM video ORDER BY count DESC";
	    $result = parent::query($sql, NULL);
	    return $result;
	}

	public function update($count, $video_id) {
	    $video_id = (int)$video_id;
	    $sql = "UPDATE video SET count=:count WHERE video_id=:video_id";
	    $bind_value = array(":count" => array("value" => $count, "option" => PDO::PARAM_INT),
			        ":video_id" => array("value" => $video_id, "option" => PDO::PARAM_INT));
	    if (Judge::isArrayNaturalNumber(array($count, $video_id)) === false) return false;
            $result = parent::query($sql, $bind_value);
	    return $result;
	}
}
