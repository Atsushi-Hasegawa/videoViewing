<?php
session_start();
define("ROOT_DIR","/var/www");
require_once(ROOT_DIR."/html/movie/Movie.class.php");
$movie = new Movie();
if (isset($_POST["request"]) && $_POST['request'] != "" &&
    $_POST["time"] > 0 && $_POST["time"] < $_POST["max"]) {
	$xaxis = rand(400,600);
	$yaxis = rand(10,200);
	$str = "{time:".round($_POST["time"],2).", message:'".$_POST["request"]."', x:$xaxis, y:$yaxis}";
	$movie->addComment($_SESSION["video_id"], $str, $_SESSION["name"]);
	$movie_list = $movie->getComment($_SESSION["video_id"]);
} else if (empty($_POST['request'])) {
	echo "コメントが入力されていません";
} else if ($_POST["time"] <= 0 || $_POST["time"] < $_POST["max"]) {
	echo "動画再生中にコメントしてください";
}
//再生回数の更新
if (isset($_POST["currentViewCount"]) && isset($_POST["addCount"])) {
	$count = 0;
	if ($_POST["addCount"] !== NULL) {
		$count = $_POST["currnetViewCount"] + $_POST["addCount"];
	} else {
		$count = $_POST["addCount"];
	}	
	$movie->updateViewCount($count, $_SESSION["video_id"]);
}
//tagの追加
if (isset($_POST["tag"])) {
	$movie->addTag($_POST["tag"], $_SESSION["video_id"]);
}
