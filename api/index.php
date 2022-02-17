<?php
	header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    //include_once $_SERVER["DOCUMENT_ROOT"] . '/config/database.php';
    include_once $_SERVER["DOCUMENT_ROOT"] . '/cloudcms/include/classes/all_classes.php';


//     echo $_GET['call'].'/'.$_GET['action'].'.php'.'<br>';
    
    include $_SERVER["DOCUMENT_ROOT"] . '/plugins/' . $_GET['call'].'/api/calls/'.$_GET['action'].'/' . $_GET['method'] . '.php';
?>