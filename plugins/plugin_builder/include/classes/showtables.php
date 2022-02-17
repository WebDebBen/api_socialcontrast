<?php
	$request_method=$_SERVER["REQUEST_METHOD"];

	include_once '../../../../config/config.php';
	include_once '../../../../config/database.php';

	$db = new Database();
	$db->getConnection(API_DB_NAME );
    switch($request_method)
	{
		case 'GET':
			handle_get_method();
			break;
		default:
			handle_post_method();
			break;
	}

	function handle_get_method(){
		handle_show_table();
	}

	function handle_post_method(){
		header("HTTP/1.0 405 Method Not Allowed");
	}

	function handle_show_table(){
		$db = $GLOBALS["db"];

		$result = ["status"=> "success"];
		$data = $db->show_tables();
		$result["data"] = $data;
		response_data(200, $result );
	}

	function handle_sub_method($seg ){
		$result = ["status"=> "success"];
		response_data(200, $result );
	}

	function response_data($code, $data ){
        header('X-PHP-Response-Code: '.$code, true, $code);
		header('Content-Type: application/json');
		echo json_encode($data );
	}

?>