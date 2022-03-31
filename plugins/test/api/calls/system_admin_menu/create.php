<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
	$get_params = isset($_POST) ? $_POST : [];
	include_once("system_admin_menu.php");
	include_once 'E:/Working/newweb/apisocial/source/config/config.php'; 
	include_once 'E:/Working/newweb/apisocial/source/config/database.php'; 
	$db = new Database();
	$db->getConnection(API_DB_NAME );
	$model = new SystemAdminMenu($db->conn );
	$data = $model->create($get_params );
	if ($data["result"] == true ){
		http_response_code(200);
	}else{
	http_response_code(500); }
	echo json_encode($data);
 ?>