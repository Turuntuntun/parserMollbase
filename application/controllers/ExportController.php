<?php
/**
 * Created by PhpStorm.
 * User: Юра
 * Date: 03.11.2019
 * Time: 21:45
 */

namespace application\controllers;

use application\core\Controller;

class ExportController extends Controller
{
    public function mainAction(){
        $this->model->export();
    }
}