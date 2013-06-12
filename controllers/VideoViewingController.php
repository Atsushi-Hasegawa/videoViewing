<?php
session_start();
session_regenerate_id(true);
define("ROOT_DIR","/var/www");
require_once(ROOT_DIR."/libs/MySmarty.class.php");
require_once(ROOT_DIR."/html/movie/models/SearchMovie.class.php");
require_once(ROOT_DIR."/html/movie/models/ViewCount.class.php");
require_once(ROOT_DIR."/html/movie/models/DbConnect.class.php");
$connect = new DbConnect();
$smarty = new MySmarty();
$result = array();
$movie_list = array(array());
if (empty($_SESSION["name"])) {
	header("Location: index.php");
} else {
	if ($connect === false) { 
		$message = "データベースに接続できません";
		$smarty->assign("message", $message);
		$smarty->display("videoViewing.html");
	} else {
		$movie = new SearchMovie($connect);
		$view_count = new ViewCount($connect);
		$comment_list = $movie->getComment($_SESSION["video_id"]);
		$view_count_list = $view_count->getRanking();
		if (!empty($comment_list[0])) {
			foreach ($comment_list as $key => $comment) {
				$movie_list[$key]["comment"] = $comment["com"];
			}
		}
		
		foreach ($view_count_list as $view_list) {
			if ($_SESSION["video_id"] === $view_list["video_id"]) {
				$result["title"] = $view_list["title"];
				$result["tag"] = $view_list["tag"];
				$result["url"] = $view_list["url"];
				$result["count"] = $view_list["count"];
				$result["supplier"] = $view_list["usr"];
			}
		}
	}
}
$smarty->assign("movie_list", $movie_list);
$smarty->assign("result", $result);
$smarty->display("VideoViewing.html");
?>
