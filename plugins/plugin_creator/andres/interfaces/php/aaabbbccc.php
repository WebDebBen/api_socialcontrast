<?php
	include_once("../../../../config/config.php");
	include_once("./aaabbbccc_sql.php");include_once '../../../../config/database.php';$db = new Database();$db->getConnection(API_DB_NAME );
	extract($_POST);
	switch($type ){
		case "init_table":
			init_table();
			break;
		case "delete":
			delete_tr($id);
			break;
		case "save":
			save_tr($id ,$bbb,$ccc,$ddd);
			break;
	}
function init_table(){
	$query = $GLOBALS["query"];
	$db = $GLOBALS["db"];
	$result = $db->load_data("aaabbbccc");
	$data = [];
	if($result){
		while ($row = $result->fetch(PDO::FETCH_BOTH)){
			$item = [];
			array_push($item, $row["id"]);
			array_push($item, $row["bbb"]);
			array_push($item, $row["ccc"]);
			array_push($item, $row["ddd"]);
			array_push($data, $item );
		}
	}
	echo json_encode(["status"=>"success", "data"=> $data ]);
}
function delete_tr($id ){
	$query = "delete from aaabbbccc where id={$id}";
	$db = $GLOBALS["db"];
	$db->run_query($query );
	echo json_encode(["status"=> "success"]);
}
function save_tr($id, $bbb,$ccc,$ddd){
	$db = $GLOBALS["db"];
	if ($id == "-1"){
		$query = "insert into aaabbbccc set bbb='{$bbb}',ccc='{$ccc}',ddd='{$ddd}'";
	}else{
		$query = "update aaabbbccc set bbb='{$bbb}',ccc='{$ccc}',ddd='{$ddd}' where id={$id}";
	}
	$id = $db->update_query($query );
	echo json_encode(["status"=> "success", "id"=> $id ]);
}
?>