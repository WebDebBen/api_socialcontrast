<?php
	include_once("../../../../config/config.php");
	include_once("./profiles_sql.php");include_once '../../../../config/database.php';$db = new Database();$db->getConnection(API_DB_NAME );
	extract($_POST);
	switch($type ){
		case "init_table":
			init_table();
			break;
		case "delete":
			delete_tr($id);
			break;
		case "save":
			save_tr($id ,$name,$photo,$bigo);
			break;
	}
function init_table(){
	$query = $GLOBALS["query"];
	$db = $GLOBALS["db"];
	$result = $db->load_data("profiles");
	$data = [];
	if($result){
		while ($row = $result->fetch(PDO::FETCH_BOTH)){
			$item = [];
			array_push($item, $row["id"]);
			array_push($item, $row["name"]);
			array_push($item, $row["photo"]);
			array_push($item, $row["bigo"]);
			array_push($data, $item );
		}
	}
	echo json_encode(["status"=>"success", "data"=> $data ]);
}
function delete_tr($id ){
	$query = "delete from profiles where id={$id}";
	$db = $GLOBALS["db"];
	$db->run_query($query );
	echo json_encode(["status"=> "success"]);
}
function save_tr($id, $name,$photo,$bigo){
	$db = $GLOBALS["db"];
	if ($id == "-1"){
		$query = "insert into profiles set name='{$name}',photo='{$photo}',bigo='{$bigo}'";
	}else{
		$query = "update profiles set name='{$name}',photo='{$photo}',bigo='{$bigo}' where id={$id}";
	}
	$id = $db->update_query($query );
	echo json_encode(["status"=> "success", "id"=> $id ]);
}
?>