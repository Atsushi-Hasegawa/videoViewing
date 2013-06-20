<?php

class AdduserController {
	private $_db;
	private $_user;
	private $_smarty;
	public $_db_error = "データベースに接続できませんでした";
        public $_empty_user_info = "ユーザ名またはパスワードが入力されていません";
        public $_registered_user_info = "既に登録されています";
        public $_user_info = "登録ありがとうございます";

	public function __construct() {
	    $this->_db     = new DbConnect();
	    $this->_user   = new User();
	    $this->_smarty = new SetUpSmarty();
	    $this->_judge  = new Judge();
	}

	public function execute() {
	    if ($this->_db === false) return $this->getMessage($this->_db_error);
	    if ($this->_judge->isExistParameter($_POST) === false) return $this->getMessage($this->_empty_user_info);
	    $user_list = $this->_user->getUser();
	    if ($this->_user->isAuthorities($user_list, $_POST["name"] ,
	    $_POST["password"]) === false) return $this->getMessage($this->_registered_user_info);
	    $this->_user->addUser($_POST);
	    $this->getMessage($this->_user_info);
	}
	
	public function getMessage($message) {
	    $this->_smarty->assign("message", $message);
	    $this->_smarty->display("AddUser.html");
        }
}
