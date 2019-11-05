<?php
/**
 * Created by PhpStorm.
 * User: Юра
 * Date: 12.10.2019
 * Time: 1:01
 */

namespace application\core;

class View
{
    public $path;
    public $route;
    public $layout = 'default';

    public function __construct($route)
    {
        $this->route = $route;
        $this->path = $route['controller'].'/'.$route['action'];
    }

    public function render($title, $vars = [])
    {

        ob_start();
        require 'application/view/'.$this->path.'.php';
        $content = ob_get_clean();
        require 'application/view/layouts/'.$this->layout.'.php';
    }

    public static function errorCode($code)
    {
        http_response_code($code);
        require 'application/view/errors/'.$code.'.php';
        exit();
    }

    public function redirect($url){
        header('Location:',$url);
        exit;
    }


}