<?php

namespace PFW\Controllers;

use PFW\Core\Controller;

class MainController extends Controller
{
    public function indexAction()
    {
        $this->view->render('Main page');
    }

}