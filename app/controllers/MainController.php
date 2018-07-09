<?php

namespace PFW\Controllers;

use PFW\Core\Controller;

class MainController extends Controller
{
    public function indexAction()
    {
        $result = $this->model->getTicker();
        $this->view->render('Main page');
    }

}