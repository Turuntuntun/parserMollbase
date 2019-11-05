<?php

namespace application\controllers;

use application\core\Controller;

class MainController extends Controller
{
    public function mainAction()
    {
        $this->view->render('Изменение событий');
    }

}