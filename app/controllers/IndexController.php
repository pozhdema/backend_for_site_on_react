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
//                '/static/media/IMG_0624-min.f0498765.jpg',
                '/static/media/IMG_2598-compressor.015af6db.jpg',
                '/static/media/IMG_0437-compressor.578fa943.jpg',
                '/static/media/20190303165950_IMG_2463-compressor.f4fb8ea0.jpg',
                '/static/media/20180922062108_IMG_1751-compressor.6e3a542a.jpg'
            ]
        );
        return $this->response->json();
    }
}