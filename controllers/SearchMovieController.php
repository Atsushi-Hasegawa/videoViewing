<?php
define("ROOT_DIR", "/var/www");
require_once(ROOT_DIR. "/libs/MySmarty.class.php");
require_once(ROOT_DIR. "/libs/Format.class.php");
require_once(ROOT_DIR. "/html/movie/models/SearchMovie.class.php");
require_once(ROOT_DIR. "/html/movie/models/DbConnect.class.php");
session_start();
session_regenerate_id(true);
$smarty = new MySmarty();
$message = null;
$keyword = null;
$movie_list = array(array());
if (empty($_SESSION["name"])) {
	header("Location: index.php");
} else {
	$connect = new DbConnect();
	if($connect === false) {
		$messgae = "データベースに接続できませんでした";
		$smarty->assign("message", $message);
		$smarty->display("searchMovie.html");
	} else {
		$search_movie = new SearchMovie($connect);
		$format = new Format();
		$message = $_SESSION["name"]."さんようこそ";
		if (isset($_GET["set"])) {
			if (empty($_GET["keyword"])) {
				$message = "検索ワードが入力されていません.";
			} else {
				$keyword = $format->h($_GET["keyword"]);
				//title, tagのチェックされているかの確認
				if (isset($_GET["title"]) && isset($_GET["tag"])) {
					$movie_list = ($search_movie->getTitle($keyword) === false)
						    ? $search_movie->getTag($keyword)
						    : $search_movie->getTitle($keyword);
				} else if (isset($_GET["title"])) {
					$movie_list = $search_movie->getTitle($keyword);
				} else if (isset($_GET["tag"])) {
					$movie_list = $search_movie->getTag($keyword);
				} else $message = "タイトル，タグのどちらかを選択してください";

				//該当する動画があるかを確認
				if (!empty($movie_list[0])) {
					foreach ($movie_list as $list) {
						$_SESSION['video_id'] = $list['video_id'];
					}
				}
				if (empty($movie_list[0]) && 
						(isset($_GET["title"]) || isset($_GET["tag"]))) {
					$message = $keyword."を含む動画はありませんでした";
				}
			}
		}
	}
}
$smarty->assign("message", $message);
$smarty->assign("data_list", $movie_list);
$smarty->assign("keyword", $keyword);
$smarty->display("SearchMovie.html");
