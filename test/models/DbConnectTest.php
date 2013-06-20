<?php
require_once("/var/www/html/movie/models/DbConnect.class.php");
require_once("/var/www/html/movie/models/DbConnectFacade.class.php");

class DbConnectTest extends PHPUnit_Framework_TestCase {
	private $_db;
	private $_default_sql = "SELECT * FROM video WHERE id = :id";

	public function setUp() {
	    $this->_db = new DbConnect();
	}

	/**
	*    @dataProvider configProvider
	*/
	public function testConfigParameter($expect_flag, $config) {
            $this->assertSame($expect_flag, DbConnectFacade::getConfigFromFile($config));
	}
	
	public function configProvider() {
            $config = array();
	    $config[] = array(array("", "", ""), null);
	    $config[] = array(array("", "", ""), true);
	    $config[] = array(array("", "", ""), array(1));
	    $config[] = array(array("", "", ""), "dsn");
	    $config[] = array(array("", "", ""), "dsn user");
	    $config[] = array(array("", "", ""), "dsn user pass uri");
	    $config[] = array(array("", "", ""), "dsn\nuser\n");
	    $config[] = array(array("", "", ""), "dsn\tuser\t");
	    return $config;
	}
	
	/**
	* @dataProvider queryProvider
	*/
	public function testQueryParameter($sql, $bind_value) {
            $this->assertFalse($this->_db->query($sql, $bind_value));
	}

	public function queryProvider() {
            $query = array();
            $query[] = array(null, null);
            $query[] = array(true, null);
            $query[] = array(array(), null);
            $query[] = array("hoge", null);
            $query[] = array("hoge", "hoge");
            $query[] = array("hoge", true);
            $query[] = array("hoge", array());
            return $query;
	}

	/**
	* @dataProvider bindValueProvider
	*/
	public function testBindValueProvider($expect_value, $bind_value) {
            $this->assertSame($expect_value, $this->_db->getBindParameter($bind_value));
	}
	
	public function bindValueProvider() {
            $bind_value = array();
            $bind_value[] = array(array(), null);
            $bind_value[] = array(array(), "hoge");
            $bind_value[] = array(array(), true);
            $bind_value[] = array(array(), array());
            $bind_value[] = array(array(),array(null =>array("value" => null, "option" => null)));
            $bind_value[] = array(array(),array(":id" =>array(null => "hoge", "option" => 1)));
            $bind_value[] = array(array(),array(":id" =>array("value" => true, null => 1)));
            $bind_value[] = array(array(),array(":id" =>array("value" => null, "option" => 1)));
            $bind_value[] = array(array(),array(":id" =>array("value" => "hoge", "option" => null)));
            return $bind_value;
	}
}
