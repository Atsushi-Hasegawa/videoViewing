<?php
require_once("/var/www/html/movie/models/User.class.php");

class TestUser extends PHPUnit_Framework_TestCase {
	private $_default_user_list = array("name" => "hoge", "pass" =>  1234);
	private $_user;

	public function setUp() {
    	$this->_user = new User();
	}

	/**
	*    @dataProvider addUserProvider
	*/
	public function testAddUser($user) {
            $this->assertFalse($this->_user->addUser($user));
	}
	
	public function addUserProvider() {
            $add_user = array();
            $add_user[] = array(null);
            $add_user[] = array(true);
            $add_user[] = array("hoge");
            $add_user[] = array(array(null, null));
            $add_user[] = array(array(null, true));
            $add_user[] = array(array(true, true));
            $add_user[] = array(array(null, array()));
            $add_user[] = array(array(array(), null));
            $add_user[] = array(array("hoge", "hoge"));
            return $add_user;
	}
	
	/**
	*    @dataProvider userListProvider
	*/
	public function testIsAuthorities($users, $name, $pass) {
            $this->assertFalse($this->_user->isAuthorities($users, $name, $pass));
	}
	
	public function userListProvider() {
            $user_list = array();
            $user_list[] = array(null, null, null);
            $user_list[] = array(null, "hoge", sha1(1234));
            $user_list[] = array($this->_default_user_list, null, null);
	    $user_list[] = array($this->_default_user_list, "hoge", null);
	    $user_list[] = array($this->_default_user_list, null, sha1(1234));
            $user_list[] = array($this->_default_user_list, array(), null);
            $user_list[] = array($this->_default_user_list, true, null);
            $user_list[] = array($this->_default_user_list, null, array());
            $user_list[] = array($this->_default_user_list, null, true);
            return $user_list;
	}
}
