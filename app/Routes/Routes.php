<?php
use App\Middlewares\AuthenticationMiddleware;

/* WEB */
$router->group("", AuthenticationMiddleware::class)->namespace("App\Controllers");
$router->get("/", "Web:index", "web.index");

/* OPS */
$router->group("ops")->namespace("App\Controllers");
$router->get("/{errcode}", "Error:error", "error.error");

/* ADMIN */
$router->group("admin")->namespace("App\Controllers");
$router->get("/", "Admin:index", "admin.index");

