<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../app/config/app.php';
require_once '../app/config/database.php';
require_once '../app/vendor/autoload.php';


use app\App;
App::run();
