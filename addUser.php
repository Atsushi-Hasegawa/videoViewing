<?php

define("ROOT_DIR","/var/www");
require_once(ROOT_DIR."/html/movie/Usr.class.php");
require_once(ROOT_DIR."/libs/MySmarty.class.php");
$usr = new Usr();
$usr_list = $usr->getUser();
$smarty = new MySmarty();
session_start();
session_regenerate_id(true);
$message ="";
if(isset($_POST["new"])){
	if(empty($_POST["name"]) == false && 
			empty($_POST["password"]) == false){
		if($usr_list){
			foreach($usr_list as $user){
				if($_POST["name"] != $user["name"] && 
						sha1($_POST["password"]) != $user["password"]){
					$usr->addUser($_POST);
					$message = "登録ありがとうございます";
				}elseif($_POST["name"] == $user["name"] || sha1($_POST["password"] == $user["password"])){
					$message = "既に登録されています";
				}
			}
		}
	}else{
		if($_POST["name"] == "" && $_POST["password"] ==""){
			$message = "ユーザ名，パスワードを入力してください";
		}elseif($_POST["name"] == ""){
			$message = "ユーザ名を入力してください";
		}elseif($_POST["password"] ==""){
			$message = "パスワードを入力してください";
		}
	}
}
$smarty->assign("message", $message);
$smarty->display("create.html");
?>

