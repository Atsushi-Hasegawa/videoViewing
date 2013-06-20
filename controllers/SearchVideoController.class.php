<?php

class SearchVideoController {
	private $_smarty;
	private $_db;
	private $_format;
	private $_video;
	public $_empty_keyword = "検索ワードが入力されていません";
	public $_checkbox = "タグまたはタイトルをチェックしてください";
	public $_no_video = "投稿動画はありません";

	public function __construct() {
	    $this->_smarty = new SetUpSmarty();
	    $this->_db = new DbConnect();
	    $this->_format = new Format();
	    $this->_video = new Video();
	}
	
	public function execute() {
	    if (empty($_SESSION["name"])) header("Location: IndexController");
	    if ($this->_db === false) return $this->getMessage($this->_db_error, NULL);
	    if (isset($_GET["set"]) && empty($_GET["keyword"])) return $this->getMessage($this->_empty_keyword, NULL);
	    if (empty($_GET["title"]) && empty($_GET["tag"])) return $this->getMessage($this->_checkbox, NULL);
	    $video_list = $this->searchVideo($this->_format->encode($_GET["keyword"]));
	    if(empty($video_list)) return $this->getMessage($this->_no_video, NULL);
	    foreach ($video_list as $video) {
		$_SESSION["video_id"] = $video["video_id"];
	    }
	    $this->getMessage(NULL, $video_list);
	}
	
	public function getMessage($message, $video_list) {
	    if (isset($video_list)) $this->_smarty->assign("video_list", $video_list);
	    $this->_smarty->assign("message", $message);
	    $this->_smarty->display("SearchVideo.html");
	}

	public function searchVideo($keyword) {
	    $video = $this->_video->getTitle($keyword);
	    if (empty($video)) return $this->_video->getTag($keyword);
	    return $video;
	}
}
