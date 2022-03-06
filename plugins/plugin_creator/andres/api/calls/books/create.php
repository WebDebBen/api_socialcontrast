<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
	$get_params = isset($_POST) ? $_POST : [];
	include_once("books.php");
	include_once 'C:/wamp64/www/api_socialcontrast/config/config.php'; 
	include_once 'C:/wamp64/www/api_socialcontrast/config/database.php'; 
	$db = new Database();
	$db->getConnection(API_DB_NAME );
	$model = new Books($db->conn );
	$data = $model->create($get_params );
	if ($data["result"] == true ){
		http_response_code(200);
	}else{
	http_response_code(500); }
	echo json_encode($data);
 ?>