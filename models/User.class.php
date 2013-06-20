<?php
require_once("/var/www/html/movie/models/DbConnect.class.php");

class User extends DbConnect {
	public function getUser() {
	    $sql = "SELECT * FROM person";
            $result = parent::query($sql, NULL);
	    return $result;
	}

	public function addUser($user) {
            if (empty($user) || is_array($user)) return false;
	    $sql = "INSERT INTO person(name, password) ";
	    $sql.= "VALUES(:name, :password)";
	    $bind_value = array(":name" => array("value" => $user["name"], "option" => PDO::PARAM_STR),
	                        ":password" => array("value" => sha1($user["password"]), "option" => PDO::PARAM_STR));
	    $result = parent::query($sql, $bind_value);
	    return $result;
	}

	public function isAuthorities($user_list, $name, $pass) {
            if (empty($user_list) || is_array($user_list) === false) return false;
	    foreach ($user_list as $user) {
	        if(isset($user["name"], $user["password"]) === false) return false;
		if ($user["name"] === $name && $user["password"] === sha1($pass)) return true;
	    }
	    return false;
	}
}
