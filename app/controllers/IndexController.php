<?php

namespace App\Controllers;

use Core\Mvc\Controller;

class IndexController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        echo 321;
    }
}