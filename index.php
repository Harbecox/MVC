<?php
//ini_set('display_errors', 1);
ini_set("max_file_uploads",100);
header('Content-Type: text/html; charset=utf-8');

include_once 'classes/mysqldb.php';
require_once 'classes/Twig/Autoloader.php';
require_once 'classes/pagination.php';

require_once 'classes/controller.php';
require_once 'classes/model.php';
require_once 'classes/view.php';

include_once 'config.php';
include_once 'route.php';

Route::start();

function pp($arr){
    echo "<pre>";
    print_r($arr);
}

?>