<?php
define("ROOT_DIR", "/var/www/html/movie");
require_once(ROOT_DIR. "/libs/Judge.class.php");
require_once(ROOT_DIR. "/models/Video.class.php");

class TestVideo extends PHPUnit_Framework_TestCase {
	private $_video;

	public function setUp() {
	    $this->_video = new Video();
	}

	/**
	*    @dataProvider keywordListProvider
	*/
	public function testGetTitle($expect_flag, $keyword) {
            $this->assertSame($expect_flag, $this->_video->getTitle($keyword));
	}

	/**
	*    @dataProvider keywordListProvider
	*/
	 public function testGetTag($expect_flag, $keyword) {
            $this->assertSame($expect_flag, $this->_video->getTag($keyword));
	}

	public function keywordListProvider() {
            $keyword = array();
	    $keyword[] = array(false, null);
            $keyword[] = array(false, array());
            $keyword[] = array(false, true);
            return $keyword;
	}

	/**
	*    @dataProvider addTagListProvider
	*/
	public function testAddTag($tag, $video_id) {
            $this->assertFalse($this->_video->addTag($tag, $video_id));
	}
	
	public function addTagListProvider() {
            $add_tag = array();
            $add_tag[] = array(null, null);
            $add_tag[] = array(null, 1);
            $add_tag[] = array("hoge", -1);
            $add_tag[] = array("hoge", "hoge");
            $add_tag[] = array("hoge", false);
            return $add_tag;
	}

	/**
	*    @dataProvider contributeProvider
	*/
	public function testContribute($upfile) {
            $this->assertFalse($this->_video->contribute($upfile));
	}
	
	public function contributeProvider() {
            $upfile = array();
            $upfile[] = array(null);
            $upfile[] = array(array());
            $upfile[] = array(true);
            $upfile[] = array(array(1,1,1,1,1,1,null));
            $upfile[] = array(array(null,1,1,1,1,1,1));
            $upfile[] = array(array(1,null,1,1,1,1,1));
            $upfile[] = array(array(1,1,null,1,1,1,1));
            $upfile[] = array(array(1,1,1,null,1,1,1));
            $upfile[] = array(array(1,1,1,1,null,1,1));
            $upfile[] = array(array(1,1,1,1,1,null,1));
            $upfile[] = array(array(1,1,1,1,1,1,"count" => "hoge"));
            $upfile[] = array(array(1,1,1,1,1,1,"count" => false));
            $upfile[] = array(array(1,1,1,1,1,1,"count" => array()));
            return $upfile;
	}

	/**
	*    @dataProvider videoIdProvider
	*/
	public function testVideoInfo($video_id) {
            $this->assertFalse($this->_video->getVideoInfo($video_id));
	}
	
	public function videoIdProvider() {
            $number_list = array();
            $number_list[] = array(null);
            $number_list[] = array(true);
            $number_list[] = array("hoge");
            $number_list[] = array(array());
            return $number_list;
	}
}
