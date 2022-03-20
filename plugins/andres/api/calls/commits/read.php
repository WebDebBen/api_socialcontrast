<?php 
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	$get_params = isset($_GET) ? $_GET : [];
	include_once("commits.php");
	include_once 'C:/wamp64/www/api_socialcontrast/config/config.php'; 
	include_once 'C:/wamp64/www/api_socialcontrast/config/database.php'; 
	$db = new Database();
	$db->getConnection(API_DB_NAME );
	$model = new Commits($db->conn );
	$data = $model->read($get_params );
	http_response_code(200);
	echo json_encode($data);
?>
