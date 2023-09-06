<?php

define("SITE_LOCAL", "universidade-local.5asec.com.br");
define("SITE_HOMOLOG", "universidade-qa.5asec.com.br");
define("SITE_PROD", "universidade.5asec.com.br");

define("API_LOCAL", "universidade-qa.5asec.com.br/api");
define("API_HOMOLOG", "universidade-qa.5asec.com.br/api");
define("API_PROD", "universidade.5asec.com.br/api");

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
} elseif ($_SERVER['SERVER_NAME'] == SITE_HOMOLOG) {
	$root = "https://" . SITE_HOMOLOG;
	$url_API = "https://" . API_HOMOLOG;

	$logCurl = TRUE;
	$showError = TRUE;
} elseif ($_SERVER['SERVER_NAME'] == SITE_PROD) {
	$root = "https://" . SITE_PROD;
	$url_API = "https://" . API_PROD;

	$logCurl = FALSE;
	$showError = FALSE;
}

define("SITE", [
	"name" => "Estrutura PHP",
	"description" => "",
	"locale" => "pt_BR",
	"imageSharer" => "images/sharer.jpg",
	"root" => $root,
	"domain" => '5asec.com.br',
	"cookie_expiration" => time() + 60 * 60 * 24,
    "gtmHead" => "",
    "gtmBody" => ""
]);

define("API", [
	"url" => $url_API,
]);

define("LOG_CURL", $logCurl);
define("SHOW_ERROR", $showError);
define('DS', DIRECTORY_SEPARATOR);
