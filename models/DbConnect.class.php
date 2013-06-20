<?php
class DbConnect {
	private $_pdo;

	public function __construct() {
	    $this->_pdo = $this->dbConnect();
	}

	private function dbConnect() {
	    try {
		    $config = $this->loadConfig();
		    $pdo = new PDO($config[0], $config[1], $config[2]);
	    } catch (PDOException $e) {
		    return false;
	    }
	    return $pdo;
	}

	private  function loadConfig() {
	    $file = @file_get_contents("/var/www/html/movie/config/DataBaseConfig.file");
	    if($file === false) return false;
	    return $this->getConfigFromFile(trim($file));
	}

	protected function getConfigFromFile($file) {
	    $config = array();
	    if (is_array($file)) return $config = array("", "", "");
	    $config = explode(" ", $file);
	    if(count($config) !== 3) return $config = array("", "", "");
	    else return $config;
	}

	public function query($sql, $bind_value) {
	    if (is_string($sql) === false) return false;
	    $stmt = $this->_pdo->prepare($sql);
	    if ($stmt === false) return false;
	    $data = $this->getBindParameter($bind_value);
	    foreach ($data as $key => $values) {
	        $stmt->bindValue($key, $values["value"], $values["option"]);
	    }
	    $result = $stmt->execute();
	    if ($result === false) return false;
	    if (preg_match("/SELECT/i" , $sql) !== 1) return $result;
	    $data_list = $stmt->fetchAll();
	    return $data_list;
	}

	public function getBindParameter($bind_value) {
	    $result = array();
	    if(is_array($bind_value) === false || empty($bind_value)) return array();
	        foreach ($bind_value as $key => $values) {
	            if (empty($key) === false && 
	                    isset($values["value"], $values["option"])) {
		        $result[$key] = $values;
	            }
	        }
	    return $result;
	}
}
