<?php


namespace App\Controllers;


use Core\DB;
use Core\Mvc\Controller;

class UserController extends Controller
{
    public function indexAction()
    {
        DB::getInstance()->getConnection();
    }

    public function loginAction()
    {
        echo "</br>" . "UserController[loginAction]";
    }

}