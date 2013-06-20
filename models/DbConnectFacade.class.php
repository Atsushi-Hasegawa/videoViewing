<?php
require_once("/var/www/html/movie/models/DbConnect.class.php");

class DbConnectFacade extends DbConnect {
	public function getConfigFromFile($file) {
	    return parent::getConfigFromFile($file);
	}
}
