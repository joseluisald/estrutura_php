<?php

namespace App\Controllers\{{themeUcfirst}};

use App\Core\Controller;

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
     * @param $router
     */
    public function __construct($router)
    {
        parent::__construct($router);

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
        $html = $this->view->addData($this->renderOptions)->render("$this->theme::pages/index");
        echo $this->htmlMin->minify($html);
    }
}