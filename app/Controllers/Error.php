<?php

namespace App\Controllers;

use App\Core\Controller;

/**
 *
 */
class Error extends Controller
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
    public function error($data): void
    {
        echo $this->view->render("$this->theme::pages/error", [
            "title" => "Error",
            "page" => "error",
            "errcode" => $data['errcode']
        ]);
    }
}