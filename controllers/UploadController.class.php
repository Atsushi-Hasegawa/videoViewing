<?php
class UploadController {
	private $_samrty;
	private $_db;
	private $_video;
	private $_judge;
	public $_cannot_upload = "ファイルをアップロードできませんでした";
	public $_no_file = "ファイルが選択されていません";
	public $_upload = "をアップロードを登録しました";

	public function __construct() {
	    $this->_smarty = new SetUpSmarty();
	    $this->_db     = new DbConnect();
	    $this->_video  = new Video();
	    $this->_judge  = new Judge();
	}
	
	public function execute() {	
	    $dir1 = "files/";
	    $dir2 = "http://49.212.163.77/movie/files/";
	    if (@is_uploaded_file($_FILES["upfile"]["tmp_name"]) === false) return $this->getMessage($this->_no_file);
	    if (@move_uploaded_file($_FILES["upfile"]["tmp_name"], $dir1. $_FILES["upfile"]["name"]) === false) return $this->getMessage($this->_cannot_upload);
	    chmod($dir1 .$_FILES["upfile"]["name"], 0644);
	    $upload = $this->setUploadInfo($_FILES);
	    exec("sudo ffmpeg -i " .$dir1 .$_FILES["upfile"]["name"]
		." -s 320x240 -vcodec libx264 -vpre default -acodec libfaac -y " .$dir1 .$upload["name"]);
	    exec("sudo ffmpeg -y -i " ."files/" .$_FILES["upfile"]["name"]
		." -f image2 -ss 15 -vframes 1 -s 250x200 " .$dir1 .$upload["thumb"]);
	    $upload["url"] = $dir2 .$upload["name"]; 
	    $upload["thumbnail"] = $dir2 .$upload["thumb"]; 
	    $this->_video->contribute($upload);
	    $this->getMessage($_FILES["upfile"]["name"].$this->_upload);
	}
	
	public function setUploadInfo($files) {
	    if ($this->_judge->isExistParameter($files) === false) return false;
	    $upload = array();
	    $upload["usr"]   = $_SESSION["name"];
	    $upload["name"]  = $files["upfile"]["name"];
	    $length          = @stripos($upload["name"], ".");
	    $upload["name"]  = @substr($upload["name"], 0, $length);
	    $upload["title"] = $_POST["title"];
	    $upload["tag"]   = $_POST["tag"];
	    $upload["thumb"] = $upload["name"];
	    $upload["name"] .= ".mp4";
	    $upload["thumb"] .= ".jpg";
	    $upload["count"] = 0;
	    return $upload;
	}
	
	public function getMessage($message) {
	    $this->_smarty->assign("message", $message);
	    $this->_smarty->display("Upload.html");
	}
}
