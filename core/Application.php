<?php

namespace Engine;

class Application
{
    public function __construct()
    {

        define('BASE_PATH', dirname(dirname(__FILE__)));
        define('CORE_PATH', dirname(dirname(__FILE__)) . "/core");
        echo 123;
    }
}