<?php
    require_once '../vendor/autoload.php';
    require_once('../app/init.php');
    define('ROOT','http://'.$_SERVER['SERVER_NAME']);
    $app = new App;