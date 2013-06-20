<?php
require_once("/var/www/html/movie/models/DbConnect.class.php");
class Comment extends DbConnect {
	public function getComment($id) {
            if (is_array($id)) return false;
	    $sql = "SELECT * from Comment WHERE video_id = :id";
	    $bind_value = array(':id' => array('value' => $id, 'option' => PDO::PARAM_INT));
	    $result = parent::query($sql, $bind_value);
            return $result;
       }

	public function addComment($id, $comment, $user) {
            if (empty($comment) || empty($user)) return false;
            if (Judge::isNaturalNumber($id) === false) return false;
	    $sql = "INSERT INTO Comment(video_id, com, usr) VALUES(:video_id, :comment, :usr)";
	    $bind_value = array(':video_id' => array('value' => $id, 'option' => PDO::PARAM_INT),
	                        ':comment' => array('value' => $comment, 'option' => PDO::PARAM_STR),
	                        ':usr' => array('value' => $user, 'option' => PDO::PARAM_STR));
	    $result = parent::query($sql, $bind_value);
                return $result;
	}
}

