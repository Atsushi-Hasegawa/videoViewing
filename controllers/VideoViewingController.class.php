<?php
class VideoViewingController {
	private $_smarty;
	private $_db;
	private $_comment;
	private $_judge;
	private $_warning = "データベースに接続できませんでした";
	private $_name = "ようこそ";

	public function __construct() {
	    $this->_smarty     = new SetUpSmarty();
	    $this->_db         = new DbConnect();
	    $this->_video      = new Video();
	    $this->_comment    = new Comment();
	    $this->_judge      = new Judge();
	}
	
	public function execute() {
	    if (empty($_SESSION["name"])) header("Location: IndexController");
	    if ($this->_db === false) return $this->getMessage($this->warning, NULL, NULL);
	    $comment_list = $this->_comment->getComment($_SESSION["video_id"]);
	    if (empty($comment_list)) return false;
	    $comment = $this->getVideoComment($comment_list);
	    $video_list = $this->_video->getVideoInfo($_SESSION["video_id"]);
	    $this->getMessage(NULL, $video_list, $comment);
	}
	
	public function getVideoComment($comment_list) {
	     $video_list = array();
	    if ($this->_judge->isExistParameter($comment_list) === false) return false;
	    foreach ($comment_list as $key => $comment) {
	        $video_list[$key]["comment"] = $comment["com"];
	    }
	    return $video_list;
	}
	
	public function getMessage($message, $video_list, $comment) {
	    $this->_smarty->assign("message", $message);
	    if ($this->_judge->isExistParameter($video_list) !== false) {
	        $this->_smarty->assign("video_info", $video_list);
	        $this->_smarty->assign("video_list", $comment);
	    }
	    $this->_smarty->display("VideoViewing.html");
	}
}
