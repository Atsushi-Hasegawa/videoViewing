<?php
define("ROOT_DIR", "/var/www/html/movie");
require_once(ROOT_DIR. "/libs/Judge.class.php");
require_once(ROOT_DIR. "/models/DbConnect.class.php");
require_once(ROOT_DIR. "/models/Video.class.php");
require_once(ROOT_DIR. "/controllers/VideoTagRecordController.class.php");

class VideoTagController extends PHPUnit_Framework_TestCase {
	private $_video_tag;
	
	public function setUp() {
	    $this->_video_tag = new VideoTagRecordController();
	}
	
	/**
	*    @dataProvider tagListProvider
	*/
	
	public function testAddTag($id, $tag) {
	    $_SESSION["video_id"] = $id;
	    $_POST["tag"] = $tag;
	    $this->assertFalse($this->_video_tag->execute());
	}

	public function tagListProvider() {
	    $tag_list = array();
	    $tag_list[] = array(null, null);
	    $tag_list[] = array(array(), null);
	    $tag_list[] = array("hoge", null);
	    $tag_list[] = array(-1, null);
	    $tag_list[] = array(true, "hoge");
	    return $tag_list;
	}
}
