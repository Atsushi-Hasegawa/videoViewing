<?php
define("ROOT_DIR", "/var/www/html/movie");
require_once(ROOT_DIR. "/controllers/CommentRecordController.class.php");
require_once(ROOT_DIR. "/models/Comment.class.php");
require_once(ROOT_DIR. "/models/DbConnect.class.php");
require_once(ROOT_DIR. "/libs/Judge.class.php");

class CommentRecordControllerTest extends PHPUnit_Framework_TestCase {
	private $_comment_record;

	public function setUp() {
	    $this->_comment_record = new CommentRecordController();
	}
	
	/**
	*    @dataProvider commentListProvider
	*/
	public function testCommentRecord($id, $request, $name, $current_time, $max_time) {
	    $_SESSION["video_id"] = $id;
	    $_SESSION["name"] = $name;
	    $_POST["request"] = $request;
	    $_POST["time"] = $current_time;
	    $_POST["max"] = $max_time;
	    $this->assertFalse($this->_comment_record->execute());
	}

	public function commentListProvider() {
	    $comment_list = array();
	    $comment_list[] = array(null, null, null, null, null);
	    $comment_list[] = array(1, null, null, null, null);
	    $comment_list[] = array(1, 1, null, null, null);
	    $comment_list[] = array(1, 1, 1, null, null);
	    $comment_list[] = array(1, 1, 1, 1, null);
	    $comment_list[] = array(1, 1, 1, 1, 1);
	    $comment_list[] = array(array(), 1, 1, 1, 1);
	    $comment_list[] = array(true, 1, 1, 1, 1);
	    $comment_list[] = array("hoge", 1, 1, 1, 1);
	    $comment_list[] = array(-1, 1, 1, 1, 1);
	    $comment_list[] = array(1, 1, 1, "hoge", 1);
	    $comment_list[] = array(1, 1, 1, true, 1);
	    $comment_list[] = array(1, 1, 1, array(), 1);
	    $comment_list[] = array(1, 1, 1, -1, 1);
	    return $comment_list;
	}
}
