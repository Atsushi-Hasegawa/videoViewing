<?php
class ViewCountRecordController {
	private $_db;
	private $_view_count;
	private $_judge;

	public function __construct() {
	    $this->_db         = new DbConnect();
	    $this->_view = new ViewCount();
	    $this->_judge      = new Judge();
	}
	
	public function execute() {
	    if ($this->_db === false) return false;
	    if ($this->_judge->isArrayNaturalNumber($_POST) === false) return false;
	    $count = $_POST["currentViewCount"] + $_POST["addCount"];
	    $result = $this->_view->update($count, $_SESSION["video_id"]);
	}
}
