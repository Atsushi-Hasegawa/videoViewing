<?php
define("ROOT_DIR", "/var/www/html/movie");
require_once(ROOT_DIR. "/libs/SetUpSmarty.class.php");
require_once(ROOT_DIR. "/libs/Judge.class.php");
require_once(ROOT_DIR. "/models/DbConnect.class.php");
require_once(ROOT_DIR. "/models/Video.class.php");
require_once(ROOT_DIR. "/controllers/UploadController.class.php");

class UploadControllerTest extends PHPUnit_Framework_TestCase {
	private $_upload;
	
	public function setup() {
	    $this->_upload = new UploadController();
	}

	/**
	* @dataProvider uploadProvider
	*/
	public function testUpload($expect_flag, $tmp_name, $name) {
	    $_FILES["upfile"]["tmp_name"] = $tmp_name;
	    $_FILES["upfile"]["name"] = $name;
	    $this->assertSame($expect_flag, $this->_upload->execute());
	}
	
	public function uploadProvider() {
	    $upload = array();
	    $upload[] = array($this->_upload->_no_file, null, null);
	    $upload[] = array($this->_upload->_no_file, array(), array());
	    $upload[] = array($this->_upload->_no_file, true, true);
	    $upload[] = array($this->_upload->_no_file, "hoge.wmv", true);
	    return $upload;
	}
	
	/**
	*    @dataProvider uploadInfoProvider
	*/
	public function testSetUploadInfo($user, $file, $title, $tag) {
	    $_SESSION["name"] = $user;
	    $_POST["title"] = $title;
	    $_POST["tag"] = $tag;
	    $this->assertFalse($this->_upload->setUploadInfo($file));
	}
	
	public function uploadInfoProvider() {
	    $upload_info = array();
	    $upload_info[] = array(null, null, null, null);
	    $upload_info[] = array(null, "hoge", null, null);
	    $upload_info[] = array(null, true, null, null);
	    $upload_info[] = array(null, 1, null, null);
	    $upload_info[] = array(null, "upfile" => array("name" => null), null, null);
	    $upload_info[] = array(null, "upfile" => array("name" => array()), null, null);
	    return $upload_info;
	}
}
