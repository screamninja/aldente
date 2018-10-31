<?php

namespace PFW\Controllers;

use PFW\Core\Controller;
use PFW\Lib\Db;
use PFW\Models\Main;

class PagesController extends Controller
{
    protected $db;

    public function __construct($route)
    {
        parent::__construct($route);
        $this->db = Db::init();
    }

    public function newsAction()
    {
        $mainObject = new Main();
        $news = $mainObject->showNews();
        $vars = [
            'news' => $news,
        ];
        $this->view->render('News page', $vars);
    }

    public function apiAction()
    {
        $vars = [];
        $this->view->render('About API', $vars, true);
    }

    public function ajaxAction()
    {
        $vars = [];
        $this->view->render('About AJAX', $vars, true);
    }

    public function loggerAction()
    {
        $vars = [];
        $this->view->render('About Logger', $vars, true);
    }

    public function aboutAction()
    {
        $vars = [];
        $this->view->render('About Page', $vars, true);
    }

    public function contactAction()
    {
        $vars = [];
        $this->view->render('Contact Page', $vars, true);
    }
}
