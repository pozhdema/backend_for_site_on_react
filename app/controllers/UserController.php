<?php


namespace App\Controllers;


use Core\DB;
use Core\Mvc\Controller;

class UserController extends Controller
{
    public function indexAction()
    {
        $id=DB::getInstance()->insert("INSERT INTO `test_table` SET `name` = ?", ['їжак']);
        print_r($id);
        $id=DB::getInstance()->delete('DELETE FROM `test_table` WHERE `id` = ?', [6]);
        print_r($id);
        $id=DB::getInstance()->select("SELECT * FROM `test_table` WHERE `id` = ?", [1]);
        print_r($id);
        $id=DB::getInstance()->update("UPDATE `test_table` SET `name` = :name WHERE `id` = :id",  ["name"=>'їжак2',"id"=>1]);
        print_r($id);
    }

    public function loginAction()
    {
        echo "</br>" . "UserController[loginAction]";
    }

}