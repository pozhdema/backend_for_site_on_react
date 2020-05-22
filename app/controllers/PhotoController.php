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
        foreach ($dataSet as $data) {
            $links[] = [
                "path" => $this->config["domain"] . $data["path"] . $data["name"],
                "id" => $data["id"]
            ];
        }
        $this->response->setStatus("success");
        $this->response->setMessage("OK");
        $this->response->setData($links);
        return $this->response->json();
    }

    public function addAction()
    {
        $uploadDir = BASE_PATH . "public/img/";
        $newFile = hash('crc32', basename($_FILES['file']['name']), false) . time() . ".jpg";
        $uploadFile = $uploadDir . $newFile;

        if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
            $id = DB::getInstance()->insert(
                "INSERT INTO `photo` ( path, name) VALUES (:path, :name)",
                ["path" => "/img/", "name" => $newFile]);
            if (!$id) {
                $this->response->setStatus();
                $this->response->setStatusCode(422);
                $this->response->setMessage("Fail don't inserted");
            } else {
                $params = ["id_photo" => $id];
                $query = "INSERT INTO `photo_category` ( id_photo, id_category) VALUES ";
                $paramsString = "";
                $categories = $this->request->getPost("categories");
                foreach ($categories as $category) {
                    $paramsString .= " (:id_photo, :id_c_{$category}),";
                    $params["id_c_{$category}"] = $category;
                }
                $paramsString = substr($paramsString, 0, -1);
                $categoryId = DB::getInstance()->insert(
                    $query . $paramsString,
                    $params
                );
                if (!$categoryId) {
                    $this->response->setStatus();
                    $this->response->setStatusCode(422);
                    $this->response->setMessage("Something when wrong");
                } else {
                    $this->response->setStatus("success");
                    $this->response->setStatusCode(200);
                    $this->response->setMessage("OK");
                    $this->response->setData([
                        "id" => $id,
                        "path"=>$this->config["domain"] . "/img/" . $newFile
                    ]);
                }
            }
        } else {
            $this->response->setStatus();
            $this->response->setStatusCode(422);
            $this->response->setMessage("Error fail did't upload");
        }
        return $this->response->json();
    }

    public function deleteAction()
    {
        $db = DB::getInstance();
        $photoData = $db->select(
            "SELECT `path`, `name` FROM `photo` WHERE id=:id",
            [
                "id" => $this->request->getPost("id")
            ]
        );
        if (empty($photoData[0])) {
            $this->response->setStatus();
            $this->response->setStatusCode(422);
            $this->response->setMessage("Photo not found");
        } else {
            if(unlink(BASE_PATH ."public".$photoData[0]["path"].$photoData[0]["name"])){
                $db->delete('DELETE FROM `photo_category` WHERE `id_photo` = :id',
                    [
                        "id" => $this->request->getPost("id")
                    ]);
                $db->delete('DELETE FROM `photo` WHERE `id` = :id',
                    [
                        "id" => $this->request->getPost("id")
                    ]);
                $this->response->setStatus("success");
                $this->response->setStatusCode(200);
                $this->response->setMessage("OK");
            }else{
                $this->response->setStatus();
                $this->response->setStatusCode(422);
                $this->response->setMessage("Photo not found");
            }
        }
        return $this->response->json();
    }

    public function getPhotoAction ()
    {
        $flags = DB::getInstance()->select(
            "SELECT `is_visible` AS visible, `slider_home` AS slider FROM `photo` WHERE id=:id",
            ["id"=>$this->request->getPost("id")]
        );
        $categories = DB::getInstance()->select(
            "SELECT `id_category` FROM `photo_category` WHERE `id_photo` = :id",
            ["id"=>$this->request->getPost("id")]
        );
        $this->response->setStatus("success");
        $this->response->setStatusCode(200);
        $this->response->setMessage("OK");
        $this->response->setData(
            [
                "visible"=>$flags[0]["visible"],
                "slider"=>$flags[0]["slider"],
                "categories"=>array_column($categories, "id_category")
            ]
        );
        return $this->response->json();
    }

    public function updateAction()
    {
        DB::getInstance()->update(
            "UPDATE `photo` SET `is_visible` = :visible, `slider_home` = :slider WHERE id=:id",
            [
                "visible"=>$this->request->getPost("visible"),
                "slider"=>$this->request->getPost("slider"),
                "id"=>$this->request->getPost("id")
            ]
        );
        DB::getInstance()->delete(
            "DELETE FROM `photo_category` WHERE `id_photo`= :id",
            ["id"=>$this->request->getPost("id")]
        );
        $params = ["id_photo" => $this->request->getPost("id")];
        $query = "INSERT INTO `photo_category` ( id_photo, id_category) VALUES ";
        $paramsString = "";
        $categories = $this->request->getPost("categories");
        foreach ($categories as $category) {
            $paramsString .= " (:id_photo, :id_c_{$category}),";
            $params["id_c_{$category}"] = $category;
        }
        $paramsString = substr($paramsString, 0, -1);
        $categoryId = DB::getInstance()->insert(
            $query . $paramsString,
            $params
        );
        if (!$categoryId) {
            $this->response->setStatus();
            $this->response->setStatusCode(422);
            $this->response->setMessage("Something when wrong");
        } else {
            $this->response->setStatus("success");
            $this->response->setStatusCode(200);
            $this->response->setMessage("OK");
        }
        return $this->response->json();
    }
}