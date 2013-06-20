<?php

class Judge {
	public function isNaturalNumber($param) {
	    if (empty($param) || is_array($param)) return false;
	    if (is_bool($param) ||
	        preg_match("/^[0-9]+$/", $param) !== 1) return false;
	    return true;
	}

	public function isArrayNaturalNumber($params) {
	    if (empty($params) || is_array($params) === false) return false;
	    foreach ($params as $param) {
	        if (empty($param) || is_bool($param)
	             || preg_match("/^[0-9]+$/", $param) !== 1) return false;
	    }
	    return true;
	}
	
	public function isExistParameter($params) {
	    if (empty($params) || is_array($params) === false) return false;
	    if (in_array(null, $params)) return false;
	    return true;
	}
}
