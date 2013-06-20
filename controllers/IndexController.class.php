<?php
class IndexController {
	private $_smarty;
	private $_db;
	private $_user;
	public  $_warning = "データベースに接続できませんでした";
	public $_miss_user_info = "ユーザ名またはパスワードが間違っています";

	public function __construct() {
	   $this->_smarty = new SetUpSmarty();
	   $this->_db = new DbConnect();
	   $this->_user = new User();
	}
	
	public function execute() {
	   if ($this->_db === false) return $this->getMessage($this->_warning);
	   if (empty($_POST["login"])) return $this->getMessage(NULL);
	   $user_list = $this->_user->getUser();
	   if ($this->_user->isAuthorities($user_list, $_POST["name"],
	       $_POST["password"]) === false) {
	        return $this->getMessage($this->_miss_user_info);
	    }
	   $_SESSION["name"] = $_POST["name"];
	   header("Location: SearchVideoController");
	}

	public function getMessage($message) {
	   $this->_smarty->assign("message", $message);
	   $this->_smarty->display("index.html");
	}
}
