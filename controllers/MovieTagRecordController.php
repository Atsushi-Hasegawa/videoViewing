<?php
session_start();
session_regenerate_id(true);
define("ROOT_DIR","/var/www");
require_once(ROOT_DIR."/html/movie/models/MovieInfo.class.php");
require_once(ROOT_DIR."/html/movie/models/DbConnect.class.php");
$connect = new DbConnect();
if ($connect !== false) {
	$MovieInfo = new MovieInfo($connect);
	if (isset($_POST["tag"])) {
		$MovieInfo->addTag($_POST["tag"], $_SESSION["video_id"]);
	}
}
