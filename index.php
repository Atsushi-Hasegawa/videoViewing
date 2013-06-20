<?php
define("ROOT_DIR", "/var/www/html/movie/");
require_once(ROOT_DIR. "/libs/SetUpSmarty.class.php");
require_once(ROOT_DIR. "/libs/Format.class.php");
require_once(ROOT_DIR. "/libs/Judge.class.php");
require_once(ROOT_DIR. "/models/User.class.php");
require_once(ROOT_DIR. "/models/DbConnect.class.php");
require_once(ROOT_DIR. "/models/Video.class.php");
require_once(ROOT_DIR. "/models/Comment.class.php");
require_once(ROOT_DIR. "/models/ViewCount.class.php");
session_start();
session_regenerate_id(true);
$params = @explode("/" , $_GET["url"]);
$controller  = ucwords(array_shift($params));
if (is_file(ROOT_DIR. "/controllers/". $controller. ".class.php") === false) {
    $redirect_url = "http://49.212.163.77/404.html";
    header("HTTP/1.0 404 Not Found");
    print(file_get_contents($redirect_url));
    exit;
}
require_once(ROOT_DIR. "/controllers/". $controller. ".class.php");
$instance = new $controller;
$ret = $instance->execute();
