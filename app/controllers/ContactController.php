<?php


namespace App\Controllers;


use Core\Mvc\Controller;

class ContactController extends Controller
{
    public function indexAction()
    {
        $this->response->setStatus("success");
        $this->response->setStatusCode(200);
        $this->response->setMessage("OK");
        return $this->response->json();
    }

}