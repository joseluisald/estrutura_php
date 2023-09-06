<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Services\AdminService;

/**
 * class Admin
 */
class Admin extends Controller
{
    /**
     * @var string
     */
    protected $theme;
    /**
     * @var AdminService
     */
    protected $adminService;

    /**
     * @param $router
     */
    public function __construct($router)
    {
        parent::__construct($router);

        $this->adminService = new AdminService();

        $this->theme = "admin";
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