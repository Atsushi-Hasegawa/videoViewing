<?php
class CommentRecordController {
	private $_db;
	private $_comment;
	private $_judge;

	public function __construct() {
	    $this->_db      = new DbConnect();
	    $this->_comment = new Comment();
	    $this->_judge   = new Judge();
	}
	
	public function execute() {
	    if ($this->_db === false) return false;
	    if ($this->_judge->isNaturalNumber($_SESSION["video_id"])) return false;
	    if ($this->_judge->isExistParameter($_POST) === false) return false;
	    if ($this->isVideoTime($_POST) === false) return false;
	    $xaxis = rand(400, 600);
	    $yaxis = rand(10, 200);
	    $comment = "{time:" .round($_POST["time"], 2) .", message:'" .$_POST["request"] ."', x:$xaxis, y:$yaxis}";
	    $this->_comment->addComment($_SESSION["video_id"], $comment, $_SESSION["name"]);
	    $movie_list = $this->_comment->getComment($_SESSION["video_id"]);
	}
	
	public function isVideoTime($video_time) {
	    if ($this->_judge->isExistParameter($video_time) === false) return false;
	    if ($video_time["time"] > 0 && $video_time["time"] < $video_time["max"]) return true;
	    return false;
	}
}
