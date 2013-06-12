<?php
session_start();
session_regenerate_id(true);
define("ROOT_DIR","/var/www");
require_once(ROOT_DIR."/html/movie/models/ViewCount.class.php");
require_once(ROOT_DIR."/html/movie/models/DbConnect.class.php");
$connect = new DbConnect();
if ($connect !== false) {
	$view_count = new ViewCount($connect);
	if (isset($_POST["currentViewCount"]) && isset($_POST["addCount"])) {
		$count = 0;
		if ($_POST["addCount"] !== NULL) {
			$count = $_POST["currentViewCount"] + $_POST["addCount"];
		} else {
			$count = $_POST["currentViewCount"];
		}	
		$view_count->update($count, $_SESSION["video_id"]);
	}
}
