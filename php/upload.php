<?php
session_start();
define('ROOT_DIR','/var/www');
require_once(ROOT_DIR.'/html/movie/Movie.class.php');
require_once(ROOT_DIR.'/libs/MySmarty.class.php');
$log ="";
$smarty = new MySmarty();
$movie = new Movie();
$dir ="http://49.212.163.77/movie/files/";
$upload = array();
$message="";
if (is_uploaded_file($_FILES["upfile"]["tmp_name"])) {
	if (move_uploaded_file($_FILES["upfile"]["tmp_name"], "files/".$_FILES["upfile"]["name"])) {
		chmod("files/".$_FILES["upfile"]["name"], 0666);
		//更新ファイルとエンコード,DB保存法のファイルを分ける
		$upload["usr"]   = $_SESSION["name"];
		$upload["name"]  = $_FILES["upfile"]["name"];
		$end             = stripos($upload["name"],".");
		$length          = $end;
		$upload["name"]  = substr($upload["name"],0,$length);
		$upload["title"] = $_POST["title"];
		$upload["tag"]   = $_POST["tag"];
		$upload["thumb"] = $upload["name"];
		$upload["name"] .=".mp4";
		$upload["thumb"] .=".jpg";
		$upload["count"] = 0;
		//動画の変換(*からmp4)
		exec('ffmpeg -i '."files/".$_FILES["upfile"]["name"].' -vcodec libx264 -vpre default -acodec libfaac -y '."files/".$upload["name"]);
		//サムネイルを作成
		exec('ffmpeg -y -i '."files/".$_FILES["upfile"]["name"].' -f image2 -ss 15 -vframes 1 -s 250x200 '."files/".$upload["thumb"]);
		//title,tag,id,titleの追加
		$upload["url"] = $dir.$upload["name"]; 
		$upload["thumbnail"] = $dir.$upload["thumb"]; 
		$movie->addMovie($upload);
		$message = $_FILES["upfile"]["name"]."をアップロードしました";
	 } else {
		$message = "ファイルをアップロードできません";
	}
} else {
	$message = "ファイルが選択されていません";
}
$smarty->assign("message", $message);
$smarty->display("upload.html");
?>

