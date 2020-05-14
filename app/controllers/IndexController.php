<?php


namespace App\Controllers;


use Core\Mvc\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {
        $this->response->setStatus("success");
        $this->response->setMessage("OK");
        $this->response->setData(
            [
                'http://qwe.loc/img/20190303165950_IMG_2463-compressor.jpg',
                'http://qwe.loc/img/20180922062108_IMG_1751-compressor.jpg',
                'http://qwe.loc/img/IMG_0437-compressor.jpg',
                'http://qwe.loc/img/IMG_0624-min.jpg',
                'http://qwe.loc/img/IMG_2598-compressor.jpg'
            ]
        );
        return $this->response->json();
    }
}