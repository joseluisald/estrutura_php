<?php
use App\Middlewares\AuthenticationMiddleware;

$router->group("", AuthenticationMiddleware::class)->namespace("App\Controllers");
$router->get("/", "Web:home", "web.home");