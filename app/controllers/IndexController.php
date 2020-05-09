<?php


namespace App\Controllers;


use Core\Mvc\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {
        $this->response->setStatus("success");
        $this->response->setMessage("OK");
        $this->response->setData($this->request->getGet());
        return $this->response->json();
    }
}