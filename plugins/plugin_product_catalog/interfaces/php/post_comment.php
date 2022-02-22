<?php
	include_once("../../../../config/config.php");
	include_once("./post_comment_sql.php");include_once '../../../../config/database.php';$db = new Database();$db->getConnection(API_DB_NAME );
	extract($_POST);
	switch($type ){
		case "init_table":
			init_table();
			break;
		case "delete":
			delete_tr($id);
			break;
		case "save":
			save_tr($id ,$post_id,$content,$thumbs);
			break;
	}
function init_table(){
	$query = $GLOBALS["query"];
	$db = $GLOBALS["db"];
	$result = $db->load_data("post_comment");
	$data = [];
	if($result){
		while ($row = $result->fetch(PDO::FETCH_BOTH)){
			$item = [];
			array_push($item, $row["id"]);
			array_push($item, $row["post_id"]);
			array_push($item, $row["content"]);
			array_push($item, $row["thumbs"]);
			array_push($data, $item );
		}
	}
	echo json_encode(["status"=>"success", "data"=> $data ]);
}
function delete_tr($id ){
	$query = "delete from post_comment where id={$id}";
	$db = $GLOBALS["db"];
	$db->run_query($query );
	echo json_encode(["status"=> "success"]);
}
function save_tr($id, $post_id,$content,$thumbs){
	$db = $GLOBALS["db"];
	if ($id == "-1"){
		$query = "insert into post_comment set post_id='{$post_id}',content='{$content}',thumbs='{$thumbs}'";
	}else{
		$query = "update post_comment set post_id='{$post_id}',content='{$content}',thumbs='{$thumbs}' where id={$id}";
	}
	$id = $db->update_query($query );
	echo json_encode(["status"=> "success", "id"=> $id ]);
}
?>