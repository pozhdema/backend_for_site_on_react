<?php


namespace Core;


class Router
{
    protected $controller = "index";
    protected $action = "index";

    public function __construct()
    {
        $queryString = strstr(substr($_SERVER["REQUEST_URI"], 1, -1), "?", true);
        $queryArray = explode('/', $queryString);
        if (count($queryArray) === 1 && count($queryArray)) {
            if (!empty($queryArray[0])) {
                $this->controller = $queryArray[0];
            }
        } else {
            if (!empty($queryArray[0])) {
                $this->controller = $queryArray[0];
            }
            if (!empty($queryArray[1])) {
                $this->action = $queryArray[1];
            }
        }

    }

    /**
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @param string $controller
     */
    public function setController($controller)
    {
        $this->controller = $controller;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param string $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

}