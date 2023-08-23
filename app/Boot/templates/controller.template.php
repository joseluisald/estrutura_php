<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Services\{{name}}Service;

/**
 * class {{name}}
 */
class {{name}} extends Controller
{
    /**
     * @var string
     */
    protected $theme;
    /**
     * @var {{name}}Service
     */
    protected ${{nameLc}}Service;

    /**
     * @param $router
     */
    public function __construct($router)
    {
        parent::__construct($router);

        $this->{{nameLc}}Service = new {{name}}Service();

        $this->theme = "{{theme}}";
        $this->renderOptions = array_merge($this->renderOptions, [
            "theme" => $this->theme
        ]);
    }

    /**
     * @return void
     */
    public function index()
    {
        echo $this->view->addData($this->renderOptions)->render("$this->theme::pages/{{nameLc}}");
    }
}