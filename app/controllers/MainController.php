<?php

namespace PFW\Controllers;

use PFW\Core\Controller;

/**
 * Class MainController
 * @package PFW\Controllers
 */
class MainController extends Controller
{
    /**
     *
     */
    public function indexAction()
    {
        $news = $this->model->showNews();
        $vars = [
            'news' => $news,
        ];
        $this->view->render('Main page', $vars);
    }
}
