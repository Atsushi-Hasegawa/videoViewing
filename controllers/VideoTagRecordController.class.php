<?php

class VideoTagRecordController {
	private $_db;
	private $_video;
	private $_judge;

	public function __construct() {
	    $this->_db    = new DbConnect();
	    $this->_video = new Video();
	    $this->_judge = new Judge();
	}
	
	public function execute() {
	    if ($this->_db === false) return false;
	    if($this->_judge->isNaturalNumber($_SESSION["video_id"]) === false) return false;
	    if (empty($_POST["tag"])) return false;
	   $this->_video->addTag($_POST["tag"], $_SESSION["video_id"]);
	}
}
