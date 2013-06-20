<?php
define("ROOT_DIR", "/var/www/html/movie");
require_once(ROOT_DIR. "/libs/Judge.class.php");
require_once(ROOT_DIR. "/models/DbConnect.class.php");
require_once(ROOT_DIR. "/models/ViewCount.class.php");
require_once(ROOT_DIR. "/controllers/ViewCountRecordController.class.php");

class TestViewCountRecordController extends PHPUnit_Framework_TestCase {
	private $_view_count;

	public function setUp() {
	    $this->_view_count = new ViewCountRecordController();
	}
	
	/**
	*    @dataProvider viewCountProvider
	*/
	public function testViewCount($id, $current_count, $add_count) {
	    $_POST["add_count"] = $add_count;
	    $_POST["current_view_count"] = $current_count;
	    $_SESSION["video_id"] = $id;
	    $this->assertFalse($this->_view_count->execute());
	}
	
	public function viewCountProvider() {
	    $view_list = array();
	    $view_list[] = array(null, null, null);
	    $view_list[] = array(1, "hoge", "hoge");
	    $view_list[] = array(1, array(), array());
	    $view_list[] = array(1, -1, -1);
	    $view_list[] = array(1, false, false);
	    return $view_list;
	}
}
