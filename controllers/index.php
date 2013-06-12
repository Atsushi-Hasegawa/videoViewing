<?php

define("ROOT_DIR", "/var/www/");
require_once(ROOT_DIR. "/libs/MySmarty.class.php");
require_once(ROOT_DIR. "/html/movie/models/User.class.php");
require_once(ROOT_DIR. "/html/movie/models/DbConnect.class.php");

$smarty = new MySmarty();
//セッションハイジャック対策
session_start();
session_regenerate_id(true);
$message = null;
$connect = new DbConnect();
if ($connect === false) {
	$message = "データベースに接続できませんでした";
} else {
	$user = new User($connect);
	$user_list = $user->getUser();
	//ユーザ，パスワード認証
	if (isset($_POST["login"])) {
		if ($user->isAuthorities($user_list, $_POST["name"], $_POST["password"])) {
			$_SESSION["name"] = $_POST["name"];
			$_SESSION["password"] = $_POST["password"];
			header("Location: SearchMovieController.php");
		} else {
			$message = "ユーザ名，パスワードとも間違っています";
		}
	}
}
$smarty->assign("message", $message);
$smarty->display("index.html");

?>

