<?php
require "../config.php";
require "../connectDB.php";
require_once __DIR__ . "/../bootstrap.php";   // chỉ cần 1 dòng này là đủ

$c = $_GET["c"] ?? "home";   // controller
$a = $_GET["a"] ?? "index";  // action

$controllerName = ucfirst($c) . "Controller";
$controllerFile = __DIR__ . "/controller/" . $controllerName . ".php";

if (!file_exists($controllerFile)) {
    die("Controller không tồn tại: $controllerName");
}

require_once $controllerFile;

$controller = new $controllerName();

if (method_exists($controller, $a)) {
    $controller->$a();
} else {
    die("Action không tồn tại: $a");
}
