<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Services\WebService;

/**
 * class Web
 */
class Web extends Controller
{
    /**
     * @var string
     */
    protected $theme;
    /**
     * @var WebService
     */
    protected $webService;

    /**
     * @param $router
     */
    public function __construct($router)
    {
        parent::__construct($router);

        $this->webService = new WebService();

        $this->theme = "web";
        $this->renderOptions = array_merge($this->renderOptions, [
            "theme" => $this->theme
        ]);
    }

    /**
     * @return void
     */
    public function index()
    {
        echo $this->view->addData($this->renderOptions)->render("$this->theme::pages/index");
    }
}