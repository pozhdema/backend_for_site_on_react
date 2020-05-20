<?php


namespace App\Controllers;


use Core\DB;
use Core\Mvc\Controller;

class PhotoController extends Controller
{
    public function listAction()
    {
        $dataSet = DB::getInstance()->select("SELECT `path`, `name`, `id` FROM `photo`");
        $links = [];
        foreach ($dataSet as $data)
        {
            $links[] =[
                "path"=> $this->config["domain"].$data["path"].$data["name"],
                "id"=> $data["id"]
                ];
        }
        $this->response->setStatus("success");
        $this->response->setMessage("OK");
        $this->response->setData($links);
        return $this->response->json();
    }
}