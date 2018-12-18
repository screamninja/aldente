<?php

namespace AlDente\Controllers;

use AlDente\Core\Controller;

/**
 * Class MainController
 * @package AlDente\Controllers
 */
class MainController extends Controller
{
    /**
     * Show news on Main page
     * Submit news from Db to render method in View
     * @return void
     */
    public function indexAction(): void
    {
        $news = $this->model->showNews();
        $vars = [
            'news' => $news,
        ];
        $this->view->render('Main page', $vars);
    }
}
