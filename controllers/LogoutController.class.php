<?php

class LogoutController {
	public function execute() {
	    $_SESSION = array();
	    return header("Location: IndexController");
	}
}
