<?php

define("ROOT_DIR", "/var/www");
require_once(ROOT_DIR. "/libs/MySmarty.class.php");
require_once(ROOT_DIR. "/html/movie/models/ViewCount.class.php");
require_once(ROOT_DIR. "/html/movie/models/DbConnect.class.php");

session_start();
session_regenerate_id(true);
$connect = new DbConnect();
if (empty($_SESSION["name"])) {
	header("Location: index.php");
} else {
	if ($connect === false) { 
		$message = "データベースに接続できませんでした";
		$smarty->assign("message", $message);
		$smarty->display("Ranking.html");
	} else {
		$view_count = new ViewCount($connect);
		$smarty = new MySmarty();
		$ranking = $view_count->getRanking();
		$name = $_SESSION["name"] ."さんようこそ";
	}
}
$smarty->assign("data_list", $ranking);
$smarty->assign("name", $name);
$smarty->display("Ranking.html");
?>

