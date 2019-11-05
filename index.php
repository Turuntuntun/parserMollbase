<?php

define('CONSTANT','true');
/**
 * Created by PhpStorm.
 * User: Юра
 * Date: 10.10.2019
 * Time: 17:53
 */
require_once('application/lib/dev.php');
use application\core\Router;
use application\lib\Db;
use application\controllers\MainController;

spl_autoload_register(function ($class_name) {
    $path = str_replace('\\','/',$class_name.'.php');
    if (file_exists($path)){
        require_once $path;
    }
});

session_start();
$class = new Router();
$class -> run();

