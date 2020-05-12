<?php


namespace App\Controllers;


use Core\Mvc\Controller;

class CategoriesController extends Controller
{
    public function ListAction()
    {
        $categories = [
            [
                "id"=>1,
                "title"=>"City"
            ],
            [
                "id"=>2,
                "title"=>"Black&White"
            ],
            [
                "id"=>3,
                "title"=>"Nature"
            ],
            [
                "id"=>4,
                "title"=>"Minimal"
            ],
        ];
        $this->response->setStatus("success");
        $this->response->setData($categories);
        $this->response->setMessage("Some error ocured");
        return $this->response->json();
    }
}