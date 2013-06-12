<?php

define("ROOT_DIR","/var/www");
require_once(ROOT_DIR."/libs/MySmarty.class.php");
require_once(ROOT_DIR."/html/movie/models/User.class.php");
require_once(ROOT_DIR."/html/movie/models/DbConnect.class.php");
$smarty = new MySmarty();
session_start();
session_regenerate_id(true);
$message = null;
$connect = new DbConnect();
if ($connect === false) {
	$message = "データベースに接続できませんでした";
} else {
	$usr = new User($connect);
	$user_list = $usr->getUser();
	if (isset($_POST["new"])) {
		if (!empty($_POST["name"]) && !empty ($_POST["password"])) {
			if ($usr_list) {
				foreach ($usr_list as $user) {
					if ($_POST["name"] !== $user["name"] && 
							sha1($_POST["password"]) !== $user["password"]) {
						$usr->addUser($_POST);
						$message = "登録ありがとうございます";
					} else if ($_POST["name"] === $user["name"] || sha1($_POST["password"] === $user["password"])) {
						$message = "既に登録されています";
					}
				}
			}
		} else {
			if ($_POST["name"] === "" && $_POST["password"] === "") {
				$message = "ユーザ名，パスワードを入力してください";
			} else if ($_POST["name"] === "") {
				$message = "ユーザ名を入力してください";
			} else if ($_POST["password"] === "") {
				$message = "パスワードを入力してください";
			}
		}
	}
}
$smarty->assign("message", $message);
$smarty->display("AddUser.html");
?>

