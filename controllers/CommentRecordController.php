<?php
session_start();
session_regenerate_id(true);
define("ROOT_DIR","/var/www");
require_once(ROOT_DIR."/html/movie/models/SearchMovie.class.php");
require_once(ROOT_DIR."/html/movie/models/MovieInfo.class.php");
require_once(ROOT_DIR."/html/movie/models/DbConnect.class.php");
$connect = new DbConnect();
if ($connect !== false) {
	$MovieInfo = new MovieInfo($connect);
	$searchMovie = new SearchMovie($connect);
	if (isset($_POST["request"]) && $_POST['request'] !== "" &&
			$_POST["time"] > 0 && $_POST["time"] < $_POST["max"]) {
		$xaxis = rand(400, 600);
		$yaxis = rand(10, 200);
		$str = "{time:" .round($_POST["time"], 2) .", message:'" .$_POST["request"] ."', x:$xaxis, y:$yaxis}";
		$MovieInfo->addComment($_SESSION["video_id"], $str, $_SESSION["name"]);
		$movie_list = $searchMovie->getComment($_SESSION["video_id"]);
	} else if (empty($_POST['request'])) {
		echo "コメントが入力されていません";
	} else if ($_POST["time"] <= 0 || $_POST["time"] < $_POST["max"]) {
		echo "動画再生中にコメントしてください";
	}
}
