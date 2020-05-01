<?php

namespace Core;

/**
 * Class AutoLoader
 * @package Core
 */
class AutoLoader
{
    /**
     * AutoLoader constructor.
     */
    public function __construct()
    {
        spl_autoload_register([$this, 'classloader']);
    }

    /**
     * Class autoload function
     *
     * @param $className
     * @throws \Exception
     */
    private function classLoader($className)
    {
        $className = strtolower(str_replace('\\', DS, $className));
        $filePath = BASE_PATH . DS . $className . ".php";
        if (file_exists($filePath)) {
            require_once($filePath);
        } else {
            throw new \Exception("Class $className can't loaded.");
        }
    }
}