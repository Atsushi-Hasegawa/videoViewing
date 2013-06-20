<?php
define("ROOT_DIR", "/var/www/html/movie");
require_once(ROOT_DIR. "/libs/SetUpSmarty.class.php");
require_once(ROOT_DIR. "/libs/Judge.class.php");
require_once(ROOT_DIR. "/models/Video.class.php");
require_once(ROOT_DIR. "/models/Comment.class.php");
require_once(ROOT_DIR. "/controllers/VideoViewingController.class.php");

class VideoViewingControllerTest extends PHPUnit_Framework_TestCase {
	private $_view_count;
	
	public function setUp() {
	    $this->_view_count = new VideoViewingController();
	}
	
	/**
	*    @dataProvider viewCountProvider
	*/
	public function testViewCount($id) {
	    $_SESSION["video_id"] = $id;
	    $_SESSION["name"] = "hoge";
	    $this->assertFalse($this->_view_count->execute());
	}
	
	public function viewCountProvider() {
	   $view_list = array();
	   $view_list[] = array(null);
	   $view_list[] = array(array());
	   $view_list[] = array(false);
	   $view_list[] = array("hoge");
	   return $view_list;
	}
	
	/**
	*    @dataProvider videoCommentProvider
	*/
	public function testVideoComment($comment) {
	    $this->assertFalse($this->_view_count->getVideoComment($comment));
	}
	
	public function videoCommentProvider() {
	    $comment_list = array();
	    $comment_list[] = array(null);
	    $comment_list[] = array(array());
	    $comment_list[] = array("hoge");
	    $comment_list[] = array(true);
	    return $comment_list;
	}
}
