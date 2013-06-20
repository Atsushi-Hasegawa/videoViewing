<?php
define("ROOT_DIR", "/var/www/html/movie");
require_once(ROOT_DIR. "/libs/Judge.class.php");
require_once(ROOT_DIR. "/models/ViewCount.class.php");

class TestViewCount extends PHPUnit_Framework_TestCase {
	private $_view_count;

	public function setUp() {
	    $this->_view_count = new ViewCount();
	}

	/**
	*    @dataProvider updateViewCountProvider
	*/
	public function testUpdateViewCount($count, $video_id) {
            $this->assertFalse($this->_view_count->update($count, $video_id));
	}
	
	public function updateViewCountProvider() {
            $view_list = array();
            $view_list[] = array(null, null);
            $view_list[] = array("hoge", null);
            $view_list[] = array(false, null);
            $view_list[] = array(-1, null);
            $view_list[] = array(1, "hoge");
            $view_list[] = array(1, -1);
            $view_list[] = array(1, false);
            return $view_list;
	}
}
