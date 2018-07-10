<?php

namespace PFW\Controllers;

use PFW\Core\Controller;

class MainController extends Controller
{
    public function indexAction()
    {
        $result = $this->model->getNews();
        $vars = [
            'news' => $result,
        ];
        $this->view->render('Main page', $vars);
    }

}