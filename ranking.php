<?php
session_start();
define("ROOT_DIR","/var/www");
require_once(ROOT_DIR."/html/movie/Movie.class.php");
require_once(ROOT_DIR."/libs/MySmarty.class.php");
$movie = new Movie();
$smarty = new MySmarty();
$ranking = $movie->getRanking();
$name = $_SESSION["name"]."さんようこそ";
$smarty->assign("data_list", $ranking);
$smarty->assign("name", $name);
$smarty->display("ranking.html");
?>

