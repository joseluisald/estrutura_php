<?php

define("SITE_LOCAL", "www.estrutura-php.com.br");
define("SITE_HOMOLOG", "");
define("SITE_PROD", "");

define("API_LOCAL", "");
define("API_HOMOLOG", "");
define("API_PROD", "");

$root = '';
$url_API = '';
$logCurl = '';
$showError = '';

if ($_SERVER['SERVER_NAME'] == SITE_LOCAL) {
	$root = "https://" . SITE_LOCAL;
	$url_API = "https://" . API_LOCAL;

	$logCurl = TRUE;
	$showError = TRUE;
    require "Minify.php";

    ini_set('display_errors', 1);
    error_reporting(E_ALL);
} elseif ($_SERVER['SERVER_NAME'] == SITE_HOMOLOG) {
	$root = "https://" . SITE_HOMOLOG;
	$url_API = "https://" . API_HOMOLOG;

	$logCurl = TRUE;
	$showError = TRUE;

	ini_set('display_errors', 1);
    error_reporting(E_ALL);
} elseif ($_SERVER['SERVER_NAME'] == SITE_PROD) {
	$root = "https://" . SITE_PROD;
	$url_API = "https://" . API_PROD;

	$logCurl = FALSE;
	$showError = FALSE;

	ini_set('display_errors', 0);
    error_reporting(0);
}

define("SITE", [
	"name" => "Estrutura PHP",
	"description" => "",
	"locale" => "pt_BR",
	"imageSharer" => "images/sharer.jpg",
	"root" => $root,
	"domain" => 'estrutura-php.com.br',
	"cookie_expiration" => time() + 60 * 60 * 24,
    "gtmHead" => "",
    "gtmBody" => ""
]);

define("DATA_LAYER_CONFIG", [
        "driver" => "mysql",
        "host" => "localhost",
        "port" => "3306",
        "dbname" => "dbname",
        "username" => "username",
        "passwd" => "passwd",
        "options" => [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_CASE => PDO::CASE_NATURAL
        ]
    ]);

define("API", [
	"url" => $url_API,
]);

define("LOG_CURL", $logCurl);
define("SHOW_ERROR", $showError);
define('DS', DIRECTORY_SEPARATOR);
