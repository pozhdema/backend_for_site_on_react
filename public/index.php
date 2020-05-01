<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set("xdebug.overload_var_dump", "off");
use Engine\Application;
require_once "../core/Application.php";
new Application();
echo BASE_PATH;