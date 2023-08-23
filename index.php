<?php
header('Set-Cookie: Universidade5asec=true; SameSite=None;Secure');
header("Cache-Control: private, max-age=10800, pre-check=10800");
header("Pragma: private");
header("Expires: " . date(DATE_RFC822, strtotime("30 day")));

ob_start();
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

ini_set('display_errors', 1);
error_reporting(E_ALL);

require __DIR__ . "/vendor/autoload.php";

use CoffeeCode\Router\Router;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

date_default_timezone_set('America/Sao_Paulo');

$router = new Router(site());
$router->namespace("App\Controllers");

include 'app/Routes/Routes.php';

$router->dispatch();

if ($router->error() && SHOW_ERROR) {
    if (substr($_SERVER["REQUEST_URI"], -1) == '/') {
        header("Location: " . rtrim($_SERVER["REQUEST_URI"], '/'), TRUE, 301);
        die;
    }

    $log = new Logger("url");
    $log->pushHandler(new StreamHandler('./logs/router_log/log_ ' . date("Y-m-d") . ' .txt', Logger::ERROR));

    $log->error("REQUEST_URI = " . @$_SERVER["REQUEST_URI"]);
    $log->error("HTTP_REFERER = " . @$_SERVER["HTTP_REFERER"]);

    $router->redirect("error.error", ["errcode" => $router->error()]);
}

ob_end_flush();
