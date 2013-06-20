<?php
define("ROOT_DIR", "/var/www/html/movie");
require_once(ROOT_DIR. "/controllers/AddUserController.class.php");
require_once(ROOT_DIR. "/models/DbConnect.class.php");
require_once(ROOT_DIR. "/models/User.class.php");
require_once(ROOT_DIR. "/libs/SetUpSmarty.class.php");
require_once(ROOT_DIR. "/libs/Judge.class.php");

class AddUserControllerTest extends PHPUnit_Framework_TestCase {
	private $_user;

	public function setUp() {
	    $this->_user = new AddUserController();
	}
	
	/**
	*    @dataProvider addUserProvider
	*/
	public function testAddUser($warning, $name, $pass) {
	    $_POST["name"] = $name;
	    $_POST["password"] = $pass;
	    $this->assertSame($warning, $this->_user->execute());
	}
	
	public function addUserProvider() {
	    $user = array();
	    $user[] = array($this->_user->_empty_user_info, null, null);
	    $user[] = array($this->_user->_empty_user_info, null, "hoge");
	    $user[] = array($this->_user->_empty_user_info, null, true);
	    $user[] = array($this->_user->_empty_user_info, null, 1234);
	    $user[] = array($this->_user->_empty_user_info, null,array());
	    $user[] = array($this->_user->_empty_user_info, "hoge", array());
	    $user[] = array($this->_user->_empty_user_info, true, array());
	    $user[] = array($this->_user->_registered_user_info, "pico", sha1(2345));
	    return $user;
	}
}
