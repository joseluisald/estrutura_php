<?php

namespace App\Core;

use App\Core\Authentication;

/**
 *
 */
class Service
{
    /**
     * @var mixed|Http
     */
    protected mixed $http;
    /**
     * @var string
     */
    protected string $user_token;
    /**
     * @var string
     */
    protected string $api;
    /**
     * @var object
     */
    protected object $me;
    /**
     * @var mixed|\Source\Core\Authentication
     */
    protected mixed $authentication;

    /**
     *
     */
    public function __construct()
	{
		$this->http = new Http();
		$this->authentication = new Authentication(null);

		$this->user_token = $this->authentication->getUserToken();
		$this->me = $this->authentication->getMe();

		$this->api = api();
	}
}
