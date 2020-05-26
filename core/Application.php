<?php


namespace Core;


use App\Controllers\IndexController;
use Core\Mvc\Controller;

class Application
{
    public function __construct()
    {
        define("APP_PATH", dirname(__FILE__, 2) . "/app/");
        define("CORE_PATH", dirname(__FILE__) . "/");
        define("BASE_PATH", dirname(__FILE__, 2) . "/");
        spl_autoload_register(function ($className) {
            $className = explode("\\", strtolower($className));
            $className[count($className) - 1] = ucfirst($className[count($className) - 1]) . ".php";
            $className = BASE_PATH . implode("/", $className);
            if (file_exists($className)) {
                require_once($className);
            } else {
                throw new \Exception("Class '$className' is not defined");
            }
        });
        $router = new Router();
        $controllerClassName = "App\\Controllers\\" . $router->getController() . "Controller";
        $controller = new $controllerClassName();
        $actionName = $router->getAction() . "Action";

        if (method_exists($controller, $actionName)) {
            $this->execute($controller, $actionName);
        } else {
            throw new \Exception("Method '$actionName' is not defined");
        }
    }

    public function execute($controller, $actionName)
    {
        /** @var Controller $controller */
        $controller->setRequest(new Request());
        $controller->setResponse(new Response());
        $controller->setConfig(yaml_parse_file(BASE_PATH."config.yaml"));
        $controller->setCookies();
        $controller->$actionName();
    }
}