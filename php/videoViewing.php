<?php
session_start();
define("ROOT_DIR","/var/www");
require_once(ROOT_DIR."/html/movie/Movie.class.php");
require_once(ROOT_DIR."/libs/MySmarty.class.php");
$movie = new Movie();
$smarty = new MySmarty();
$result = null;
$movie_list = null;
$comment_list = $movie->getComment($_SESSION["video_id"]);
$viewCount = $movie->getRanking();
if ($comment_list == false) return false;
foreach ($comment_list as $key => $comment) {
	$movie_list[$key]["comment"] = $comment["com"];
}
foreach ($viewCount as $view) {
	if ($_SESSION["video_id"] == $view["video_id"]) {
		$result["title"] = $view["title"];
		$result["tag"] = $view["tag"];
		$result["url"] = $view["url"];
		$result["count"] = $view["count"];
		$result["supplier"] = $view["usr"];
	}
}
$smarty->assign("movie_list", $movie_list);
$smarty->assign("result", $result);
$smarty->display("videoViewing.html");
?>
