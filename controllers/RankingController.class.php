<?php
class RankingController {
	private $_db;
	private $_smarty;
	private $_view_count;
	private $_db_error = "データベースに接続できませんでした";

	public function __construct() {
	    $this->_smarty = new SetUpSmarty();
	    $this->_db = new DbConnect();
	    $this->_view_count = new ViewCount();
	}

	public function execute() {
	    if (empty($_SESSION["name"])) header("Location: IndexController");
	    if($this->_db === false) return $this->getMessage($this->_db_error, NULL);
	    $ranking = $this->_view_count->getRanking();
	    if ($ranking === false) return false;
	    $this->getMessage($_SESSION["name"]."さんようこそ", $ranking);
	}

	public function getMessage($message, $ranking) {
	    if (isset($ranking)) $this->_smarty->assign("ranking_list", $ranking);
	    $this->_smarty->assign("message", $message);
	    $this->_smarty->display("Ranking.html");
	}
}
