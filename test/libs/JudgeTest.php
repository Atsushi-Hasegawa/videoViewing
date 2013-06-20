<?php
define("ROOT_DIR", "/var/www/html/movie");
require_once(ROOT_DIR. "/libs/Judge.class.php");

class JudgeTest extends PHPUnit_Framework_TestCase {
	private $_judge;

	public function setUp() {
	    $this->_judge = new Judge();
	}
	/**
	*     @dataProvider naturalNumberProvider
	*/
	public function testIsExistParameter($expect_flag, $params) {
	    $this->assertSame($expect_flag, $this->_judge->isExistParameter($params));
	}
	
	/**
	*    @dataProvider naturalNumberProvider
	*/
	public function testNaturalNumber($expect_flag, $params) {
	    $this->assertSame($expect_flag, $this->_judge->isNaturalNumber($params));
	}
	
	/**
	*    @dataProvider ArrayNaturalNumberProvider
	*/
	public function testIsArrayNaturalNumber($expect_flag, $params) {
	    $this->assertSame($expect_flag, $this->_judge->isArrayNaturalNumber($params));
	}

	public function naturalNumberProvider() {
	    $params = array();
	    $params[] = array(false, null);
	    $params[] = array(false, true);
	    $params[] = array(false, "hoge");
	    $params[] = array(false, array());
	    return $params;
	}
	
	public function ArrayNaturalNumberProvider() {
	    $params = array();
	    $params[] = array(false, null);
	    $params[] = array(false, array(true));
	    $params[] = array(false, array(-1));
	    $params[] = array(false, array(null));
	    $params[] = array(false, array("hoge"));
	    $params[] = array(false, true);
	    return $params;
	}
}
