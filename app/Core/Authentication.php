<?php

namespace App\Core;

use App\Supports\Cookie;
use App\Supports\Session;
use App\Supports\Input;

/**
 *
 */
class Authentication
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
     * @var mixed|Http
     */
    protected mixed $http;
    /**
     * @var mixed|Input
     */
    protected mixed $input;

	/**
	 * @param $router
	 */
	public function __construct($router)
	{
		$this->cookie = new Cookie();
		$this->session = new Session();
		$this->input = new Input();
		$this->http = new Http();

		$this->router = $router;
	}

}
