<?php
define("ROOT_DIR", "/var/www/html/movie");
require_once(ROOT_DIR. "/controllers/IndexController.class.php");
require_once(ROOT_DIR. "/models/DbConnect.class.php");
require_once(ROOT_DIR. "/models/User.class.php");
require_once(ROOT_DIR. "/libs/SetUpSmarty.class.php");
require_once(ROOT_DIR. "/libs/Judge.class.php");

class IndexControllerTest extends PHPUnit_Framework_TestCase {
	private $_index;

	public function setUp() {
	    $this->_index = new IndexController();
	}
	
	/**
	*    @dataProvider UserProvider
	*/
	public function testLogin($login, $name, $pass) {
	    $_POST["login"] = $login;
	    $_POST["name"] = $name;
	    $_POST["password"] = $pass;
	    $this->assertSame($this->_index->getMessage($this->_index->_miss_user_info), 
	                      $this->_index->execute());
	}

	public function UserProvider() {
	    $login_list = array();
	    $login_list[] = array(null, null, null);
	    $login_list[] = array(array(), null, null);
	    $login_list[] = array(true, null, null);
	    $login_list[] = array("hoge", null, null);
	    $login_list[] = array("ログイン", null, null);
	    $login_list[] = array("ログイン", null, sha1(1234));
	    $login_list[] = array("ログイン", null, 1234);
	    $login_list[] = array("ログイン", null, "1234");
	    $login_list[] = array("ログイン", null, true);
	    $login_list[] = array("ログイン", null, array());
	    $login_list[] = array("ログイン", true, sha1(1234));
	    $login_list[] = array("ログイン", array(), sha1(1234));
	    return $login_list;
	}
}
