<?php
define("ROOT_DIR","/var/www");
require_once(ROOT_DIR."/html/movie/Movie.class.php");
require_once(ROOT_DIR."/libs/MySmarty.class.php");
session_start();
$smarty = new MySmarty();
$movie = new Movie();
$movie_list = array(array());
$message="";
$keyword="";
if (empty($_SESSION["name"])) {
	header("Location: index.php");
} else {
	$message = $_SESSION["name"]."さんようこそ";
	if (isset($_GET["set"])) {
		if (empty($_GET["keyword"])) {
			$message = "検索ワードが入力されていません.";
		} else {
			$keyword = $movie->format($_GET["keyword"]);
			if (isset($_GET["title"])) {
				$movie_list = $movie->getTitle($keyword);
			} else if (isset($_GET["tag"])) {
				$movie_list = $movie->getTag($keyword);
			} else {
				$message = "タイトル，タグのどちらかを選択してください";
			}
			if ($movie_list) {
				foreach ($movie_list as $list) {
					$_SESSION['title'] = $list['title'];
					$_SESSION['tag']   = $list['tag'];
					$_SESSION['video_id']   = $list['video_id'];
					$_SESSION['url']  = $list['url'];
					$_SESSION['count']  = $list['count'];
				}
			} else {
				$message = "投稿された動画がありません";
			}
		}
	}
}
$smarty->assign("message", $message);
$smarty->assign("data_list",$movie_list);
$smarty->assign("keyword",$keyword);
$smarty->display("searchMovie.html");
?>

