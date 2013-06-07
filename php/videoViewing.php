<?php
session_start();
define("ROOT_DIR","/var/www");
require_once(ROOT_DIR."/html/movie/Movie.class.php");
require_once(ROOT_DIR."/libs/MySmarty.class.php");
$movie = new Movie();
$smarty = new MySmarty();
$result = array();
$data = array(array());
$comment_list = $movie->getComment($_SESSION["video_id"]);
$viewCount = $movie->getRanking();
if($comments){
	foreach($comment_list as $key => $comment){
		$data[$key]["comment"] = $comment["com"];
	}
}
foreach($viewCount as $view){
	if($_SESSION["video_id"] == $view["video_id"]){
		$result["count"] = $view["count"];
		$result["supplier"] = $view["usr"];
	}
}
$index["tag"] = $_SESSION["tag"];
$index["title"] = $_SESSION["title"];
$index["url"] = $_SESSION["url"];
$smarty->assign("index", $index);
$smarty->assign("data", $data);
$smarty->assign("result", $result);
$smarty->display("videoViewing.html");
?>

