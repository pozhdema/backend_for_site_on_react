<?php


namespace Core\Mvc;


use Core\Request;
use Core\Response;

class Controller
{
    /**
     * @var Request
     */

    public $request;
    /**
     * @var Response
     */
    public $response;

    /**
     * @param Request $request
     */

    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    public function setResponse(Response $response)
    {
        $this->response = $response;
    }
}