<?php
/**
 * Created by PhpStorm.
 * User: Юра
 * Date: 11.10.2019
 * Time: 22:56
 */

namespace application\core;

use application\core\View;

abstract class Controller
{
    public $route;
    public $view;
    public $model;
    public $acl;
    public function __construct($route)
    {
        $this->route = $route;
        if (!$this->checkAcl()) {
            View::errorCode(403);
        };
        $this->view = new View($route);
        $this->model = $this->loadModel($route['controller']);

    }

    public function loadModel($name)
    {
        $path = 'application\models\\'.ucfirst($name);
        if (class_exists($path)) {
            return new $path;
        }
    }

    public function checkAcl()
    {
        $this->acl = require 'application/acl/'. $this->route['controller'].'.php';
        if ($this->isAcl('all')) {
            return true;
        } elseif (isset($_COOKIE['RIGHT']) and $_COOKIE['RIGHT'] === 'admin' and $this->isAcl('admin')) {
            return true;
        }
        return false;
    }

    public function isAcl($key)
    {
        if (in_array($this->route['action'],$this->acl[$key])) {
            return true;
        }
        return false;
    }

    protected function changeLayout($layout){
        $this->view->layout = $layout;
    }

    protected function checkPost($post){
        foreach ($post as $value) {
            if (!isset($_POST[$value])) {
                return false;
            }
        }
        return true;
    }
}