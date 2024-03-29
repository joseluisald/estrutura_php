<?php

namespace App\Core;

use App\Supports\Input;
use App\Supports\Seo;
use App\Supports\Session;
use League\Plates\Engine;
use App\Supports\HtmlMin;

/**
 *
 */
abstract class Controller extends Session
{
	/**
	 * @var mixed
	 */
	protected mixed $router;
	/**
	 * @var mixed|Engine
	 */
	protected mixed $view;
	/**
	 * @var mixed
	 */
	protected mixed $requestData;
	/**
	 * @var array
	 */
	protected array $renderOptions;
	/**
	 * @var mixed|Session
	 */
	protected mixed $session;
	/**
	 * @var mixed|Http
	 */
	protected mixed $http;
	/**
	 * @var mixed|\App\Supports\Input
	 */
	protected mixed $input;
    /**
     * @var mixed|Seo
     */
    protected mixed $seo;
    /**
     * @var mixed
     */
    protected mixed $htmlMin;

	/**
	 * @param $router
	 */
	public function __construct($router)
	{
        parent::__construct();

        $this->session = new Session();
        $this->input = new Input();
        $this->http = new Http();
        $this->seo = new Seo();
        $this->htmlMin = new HtmlMin();

        $this->router = $router;

        $this->view = new Engine(dirname(__DIR__, 1) . "/View");
        $this->renderOptions = [];
        $this->view->addData([
			"router" => $this->router,
			"siteName" => site("name"),
			"siteUrl" => site("root"),
			"siteDescription" => site("description"),
			"imageSharer" => asset("web", site("imageSharer")),
            "seo" => $this->seo->render(),
            "gtmHead" => SITE["gtmHead"],
            "gtmBody" => SITE["gtmBody"]
		]);

        $themesDir = dirname(__DIR__, 1) . "/View/";
        $themes = array_diff(scandir($themesDir), ['..', '.']);

        foreach ($themes as $theme) {
            $this->view->addFolder("$theme", $themesDir . "$theme", true);
        }
	}

	/**
	 * @param string $param
	 * @param mixed $values
	 * @return string
	 */
	public function decodeResponse(string $param, mixed $values): string
	{
		return json_encode([$param => $values]);
	}

	/**
	 * @param mixed $request
	 * @return string
	 */
	public function response(mixed $request): string
	{
		$response = ($request->Error == true) ? $this->decodeResponse("Error", $request) : $this->decodeResponse("Success", $request);
		return $response;
	}

	/**
	 * @param string $message
	 * @param string $type
	 * @return string
	 */
	public function ajaxMessage(string $message, string $type): string
	{
		return json_encode(["message" => "<div class=\"message {$type}\">{$message}</div>"]);
	}

	/**
	 * @param array $options
	 * @return array
	 */
	public function getRenderOptions(array $options = []): array
	{
		$renderOptions = array_merge($options, ["renderOptions" => $options]);

		return $renderOptions;
	}
}
