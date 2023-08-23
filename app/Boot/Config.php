<?php

define("SITE_LOCAL", "");
define("SITE_HOMOLOG", "");
define("SITE_PROD", "");

define("API_LOCAL", "");
define("API_HOMOLOG", "");
define("API_PROD", "");

define("SSO_LOCAL", "");
define("SSO_HOMOLOG", "");
define("SSO_PROD", "");

$root = '';
$url_API = '';
$sso_API = '';
$logCurl = '';
$showError = '';

if ($_SERVER['SERVER_NAME'] == SITE_LOCAL) {
	$root = "https://" . SITE_LOCAL;
	$url_API = "https://" . API_LOCAL;
	$sso_API = "https://" . SSO_LOCAL;
	$logCurl = TRUE;
	$showError = TRUE;
} elseif ($_SERVER['SERVER_NAME'] == SITE_HOMOLOG) {
	$root = "https://" . SITE_HOMOLOG;
	$url_API = "https://" . API_HOMOLOG;
	$sso_API = "https://" . SSO_HOMOLOG;
	$logCurl = TRUE;
	$showError = TRUE;
} elseif ($_SERVER['SERVER_NAME'] == SITE_PROD) {
	$root = "https://" . SITE_PROD;
	$url_API = "https://" . API_PROD;
	$sso_API = "https://" . SSO_PROD;
	$logCurl = FALSE;
	$showError = FALSE;
}

define("SITE", [
	"name" => "",
	"description" => "",
	"locale" => "pt_BR",
	"imageSharer" => "images/sharer.jpg",
	"root" => $root,
	"domain" => '',
	"cookie_expiration" => time() + 60 * 60 * 24
]);

define("API", [
	"url" => $url_API,
]);


define("LOG_CURL", $logCurl);
define("SHOW_ERROR", $showError);
define('DS', DIRECTORY_SEPARATOR);
