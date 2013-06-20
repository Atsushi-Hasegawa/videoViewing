<?php
define("ROOT_DIR", "/var/www/html/movie");
require_once(ROOT_DIR. "/libs/Judge.class.php");
require_once(ROOT_DIR. "/models/Comment.class.php");

class TestComment extends PHPUnit_Framework_TestCase {
	private $_comment;
	private $_judge;

	public function setUp() {
	    $this->_comment = new Comment();
	    $this->_judge   = new Judge();
	}

	/**
	*    @dataProvider VideoIdProvider
	*/
	public function testGetComment($id) {
            $this->assertFalse($this->_comment->getComment($id));
	}

	public function videoIdProvider() {
            $video_id = array();
            $video_id[] = array(null);
            $video_id[] = array(false);
            $video_id[] = array(-1);
            $video_id[] = array(array());
            $video_id[] = array("hoge");
            return $video_id;
	}

	/**
	* @dataProvider addCommentProvider
	*/
	public function testAddComment($id, $comment, $user) {
            $this->assertFalse($this->_comment->addComment($id, $comment, $user));
	}
	
	public function addCommentProvider() {
            $comment = array();
            $comment[] = array(null, null, null);
	    $comment[] = array(null, null, "hoge");
	    $comment[] = array(null, null, array());
            $comment[] = array(null, "hoge", null);
            $comment[] = array(null, array(), null);
            $comment[] = array("hoge", null, null);
            $comment[] = array(false, null, null);
            $comment[] = array(-1, null, null);
            $comment[] = array(array(), null, null);
            return $comment;
	}
}
