<?php
	include_once("../../../../config/config.php");
	include_once("./aabbcc_sql.php");include_once '../../../../config/database.php';$db = new Database();$db->getConnection(API_DB_NAME );
	extract($_POST);
	switch($type ){
		case "init_table":
			init_table();
			break;
		case "delete":
			delete_tr($id);
			break;
		case "save":
			save_tr($id ,$ab,$cd);
			break;
	}
function init_table(){
	$query = $GLOBALS["query"];
	$db = $GLOBALS["db"];
	$result = $db->load_data("aabbcc");
	$data = [];
	if($result){
		while ($row = $result->fetch(PDO::FETCH_BOTH)){
			$item = [];
			array_push($item, $row["id"]);
			array_push($item, $row["ab"]);
			array_push($item, $row["cd"]);
			array_push($data, $item );
		}
	}
	echo json_encode(["status"=>"success", "data"=> $data ]);
}
function delete_tr($id ){
	$query = "delete from aabbcc where id={$id}";
	$db = $GLOBALS["db"];
	$db->run_query($query );
	echo json_encode(["status"=> "success"]);
}
function save_tr($id, $ab,$cd){
	$db = $GLOBALS["db"];
	if ($id == "-1"){
		$query = "insert into aabbcc set ab='{$ab}',cd='{$cd}'";
	}else{
		$query = "update aabbcc set ab='{$ab}',cd='{$cd}' where id={$id}";
	}
	$id = $db->update_query($query );
	echo json_encode(["status"=> "success", "id"=> $id ]);
}
?>