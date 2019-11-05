<?php

namespace application\controllers;

use application\core\Controller;


class ParseController extends Controller
{
    public function mainAction()
    {
        if (isset($_GET['type'])) {
            $this->model->includeParse($_GET['type'],$_GET['mode'],$_GET['proxi']);
        }
        $vars['type'] = $this->model->getTypes();
        $this->view->render('Парсинг',$vars);
    }
}