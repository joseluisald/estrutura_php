<?php

namespace App\Controllers;

use App\Core\Controller;

/**
 * Class Web
 */
class Web extends Controller
{

    /**
     * @var string
     */
    protected $theme;

    /**
     * @param $router
     */
    public function __construct($router)
	{
		parent::__construct($router);

		$this->theme = "web";
		$this->renderOptions = array_merge($this->renderOptions, [
			"theme" => $this->theme
		]);
	}

	/**
	 * @return void
	 */
	public function home(): void
	{

        $html = $this->view->addData($this->renderOptions)->render("$this->theme::pages/home");
        echo $this->htmlMin->minify($html);
	}

}
