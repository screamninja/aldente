<?php

namespace PFW\Controllers;

use PFW\Core\Controller;
use PFW\Lib\Db;
use PFW\Models\Main;

/**
 * Class PagesController
 * @package PFW\Controllers
 */
class PagesController extends Controller
{
    /**
     * @var Db
     */
    protected $db;

    /**
     * PagesController constructor.
     * @param $route
     */
    public function __construct($route)
    {
        parent::__construct($route);
        $this->db = Db::init();
    }

    /**
     * News action
     * PagesController action to call render method in View class
     * and show news from Db
     * @return void
     */
    public function newsAction(): void
    {
        $mainObject = new Main();
        $news = $mainObject->showNews();
        $vars = [
            'news' => $news,
        ];
        $this->view->render('News page', $vars);
    }

    /**
     * API action
     * PagesController action to call render method in View class
     * @return void
     */
    public function apiAction(): void
    {
        $vars = [];
        $this->view->render('About API', $vars, true);
    }

    /**
     * AJAX action
     * PagesController action to call render method in View class
     * @return void
     */
    public function ajaxAction(): void
    {
        $vars = [];
        $this->view->render('About AJAX', $vars, true);
    }

    /**
     * Logger action
     * PagesController action to call render method in View class
     * @return void
     */
    public function loggerAction(): void
    {
        $vars = [];
        $this->view->render('About Logger', $vars, true);
    }

    /**
     * About action
     * PagesController action to call render method in View class
     * @return void
     */
    public function aboutAction(): void
    {
        $vars = [];
        $this->view->render('About Page', $vars, true);
    }
}
