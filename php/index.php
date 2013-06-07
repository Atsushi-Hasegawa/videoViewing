<?php

define("ROOT_DIR","/var/www");
require_once(ROOT_DIR."/html/movie/Usr.class.php");
require_once(ROOT_DIR."/libs/MySmarty.class.php");

$smarty = new MySmarty();
//セッションハイジャック対策
session_start();
session_regenerate_id(true);
$user = new Usr();
$user_list = $user->getUser();
$message = "";
//ユーザ，パスワード認証
if (isset($_POST["login"])) {
	if ($user->isAuthorities($user_list, $_POST["name"],$_POST["password"])) {
		$_SESSION["name"] = $_POST["name"];
		$_SESSION["password"] = $_POST["password"];
		header("Location: searchMovie.php");
	} else {
		$message = "ユーザ名，パスワードとも間違っています";
	}
}
$smarty->assign("message", $message);
$smarty->display("index.html");

?>

