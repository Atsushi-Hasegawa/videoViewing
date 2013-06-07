<?php
session_start();
define("ROOT_DIR","/var/www");
require_once(ROOT_DIR."/html/movie/Movie.class.php");
require_once(ROOT_DIR."/libs/MySmarty.class.php");
$movie = new Movie();
$smarty = new MySmarty();
$result = array();
$movie_list = array(array());
$message = "";
$comment_list = $movie->getComment($_SESSION["video_id"]);
$viewCount = $movie->getRanking();
if($comment_list){
	foreach($comment_list as $key => $comment){
		$movie_list[$key]["comment"] = $comment["com"];
	}
}

foreach($viewCount as $view){
	if($_SESSION["video_id"] == $view["video_id"]){
		$result["count"] = $view["count"];
		$result["supplier"] = $view["usr"];
	}
}

if (isset($_POST["request"]) && $_POST['request'] != "" &&
    $_POST["time"] > 0 && $_POST["time"] < $_POST["max"]) {
	$xaxis = rand(400,600);
	$yaxis = rand(10,200);
	$str = "{time:".round($_POST["time"],2).", message:'".$_POST["request"]."', x:$xaxis, y:$yaxis}";
	$movie->addComment($_SESSION["video_id"], $str, $_SESSION["name"]);
	$movie_list = $movie->getComment($_SESSION["video_id"]);
} else if (empty($_POST['request'])) {
	$message = "コメントが入力されていません";
} else if ($_POST["time"] <= 0 || $_POST["time"] < $_POST["max"]) {
	$message = "動画再生中にコメントしてください";
}
//再生回数の更新
if(isset($_POST["num"]) && isset($_POST["view"])){
	$count = 0;
	if($_POST["view"] !== NULL){
		$count = $_POST["view"] + $_POST["num"];
	}else{
		$count = $_POST["num"];
	}	
	$movie->updateViewCount($count, $_SESSION["video_id"]);
}
//tagの追加
if(isset($_POST["tag"])){
	$movie->addTag($_POST["tag"], $_SESSION["video_id"]);
}

$index["tag"] = $_SESSION["tag"];
$index["title"] = $_SESSION["title"];
$index["url"] = $_SESSION["url"];
$smarty->assign("index", $index);
$smarty->assign("movie_list", $movie_list);
$smarty->assign("result", $result);
$smarty->assign("message", $message);
$smarty->display("videoViewing.html");
?>

