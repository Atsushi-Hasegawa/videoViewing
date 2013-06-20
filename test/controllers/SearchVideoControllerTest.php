<?php
define("ROOT_DIR", "/var/www/html/movie");
require_once(ROOT_DIR. "/controllers/SearchVideoController.class.php");
require_once(ROOT_DIR. "/libs/SetUpSmarty.class.php");
require_once(ROOT_DIR. "/libs/Format.class.php");
require_once(ROOT_DIR. "/libs/Judge.class.php");
require_once(ROOT_DIR. "/models/Video.class.php");
require_once(ROOT_DIR. "/models/DbConnect.class.php");

class SearchVideoControllerTest extends PHPUnit_Framework_TestCase {
	private $_video;
	
	public function setUp() {
	    $this->_video = new SearchVideoController();
	}

	/**
	*    @dataProvider videoListProvider
	*/	
	public function testSearchVideo($expect_value, $set, $keyword, $title, $tag) {
	    $_GET["set"] = $set;
	    $_GET["keyword"] = $keyword;
	    $_GET["title"] = $title;
	    $_GET["tag"] = $tag;
	    $_SESSION["name"] = "hoge";
	    $this->assertSame($expect_value, $this->_video->execute());
	}

	public function videoListProvider() {
	    $video_list = array();
	    $video_list[] = array($this->_video->_empty_keyword, null, null, null, null);
	    $video_list[] = array($this->_video->_empty_keyword, array(), null, null, null);
	    $video_list[] = array($this->_video->_empty_keyword, "検索", null, null, null);
	    $video_list[] = array($this->_video->_checkbox, "検索", "hoge", null, null);
	    $video_list[] = array($this->_video->_empty_keyword, "検索", array(), "checked", null);
	    $video_list[] = array($this->_video->_empty_keyword, "検索", "hoge", array(), null);
	    $video_list[] = array($this->_video->_empty_keyword, "検索", "hoge", true, null);
	    $video_list[] = array($this->_video->_no_video, "検索", "hoge", "checked", "checked");
	    return $video_list;
	}
}
