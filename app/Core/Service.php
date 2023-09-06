<?php

namespace App\Core;

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
    protected string $api;

    /**
     *
     */
    public function __construct()
	{
		$this->http = new Http();

		$this->api = api();
	}
}
