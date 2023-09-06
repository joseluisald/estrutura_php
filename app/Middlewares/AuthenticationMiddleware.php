<?php

namespace App\Middlewares;

use App\Supports\Cookie;
use App\Supports\Session;

use CoffeeCode\Router\Router;

/**
 *
 */
class AuthenticationMiddleware
{
    /**
     * @var mixed|Cookie
     */
    protected mixed $cookie;
    /**
     * @var mixed|Session
     */
    protected mixed $session;

    /**
     *
     */
    public function __construct()
	{
		$this->cookie = new Cookie();
		$this->session = new Session();
	}

    /**
     * @param Router $router
     * @return bool
     */
    public function handle(Router $router): bool
	{
		return true;
	}
}
