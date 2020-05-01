<?php

namespace Core;

use App\Controllers\IndexController;

class Application
{
    public function __construct()
    {
        define("DS",  DIRECTORY_SEPARATOR);
        define('BASE_PATH', dirname(dirname(__FILE__)));
        define('CORE_PATH', dirname(dirname(__FILE__)) . DS . "core");
        require_once CORE_PATH . DS . "AutoLoader.php";
        new AutoLoader();
        new IndexController();
    }

}