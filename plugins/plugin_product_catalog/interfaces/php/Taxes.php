<?php
	include_once("../../../../config/config.php");
	include_once("./Taxes_sql.php");include_once '../../../../config/database.php';$db = new Database();$db->getConnection(API_DB_NAME );
	extract($_POST);
	switch($type ){
		case "init_table":
			init_table();
			break;
		case "delete":
			delete_tr($id);
			break;
		case "save":
			save_tr($id ,$name,$percentage);
			break;
	}
function init_table(){
	$query = $GLOBALS["query"];
	$db = $GLOBALS["db"];
	$result = $db->load_data("Taxes");
	$data = [];
	if($result){
		while ($row = $result->fetch(PDO::FETCH_BOTH)){
			$item = [];
			array_push($item, $row["id"]);
			array_push($item, $row["name"]);
			array_push($item, $row["percentage"]);
			array_push($data, $item );
		}
	}
	echo json_encode(["status"=>"success", "data"=> $data ]);
}
function delete_tr($id ){
	$query = "delete from Taxes where id={$id}";
	$db = $GLOBALS["db"];
	$db->run_query($query );
	echo json_encode(["status"=> "success"]);
}
function save_tr($id, $name,$percentage){
	$db = $GLOBALS["db"];
	if ($id == "-1"){
		$query = "insert into Taxes set name='{$name}',percentage='{$percentage}'";
	}else{
		$query = "update Taxes set name='{$name}',percentage='{$percentage}' where id={$id}";
	}
	$id = $db->update_query($query );
	echo json_encode(["status"=> "success", "id"=> $id ]);
}
?>