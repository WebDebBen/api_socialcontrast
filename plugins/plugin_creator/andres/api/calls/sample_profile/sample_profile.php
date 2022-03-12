<?php 
	class SampleProfile{
	private $conn;
	private $table_name = "sample_profile";
	private $page_len = 10;
	public function __construct($db ){
		$this->conn = $db;
	}
	public function read($params ){
		extract($params );
		$id = isset($id) ? $id: NULL;
		$photo1 = isset($photo1) ? $photo1: "";
		$section1 = isset($section1) ? $section1: "";
		$post_id = isset($post_id) ? $post_id: NULL;
		$created_id = isset($created_id) ? $created_id: NULL;
		$created_at = isset($created_at) ? $created_at: "";
		$FROM_created_at = isset($FROM_created_at) ? $FROM_created_at: "";
		$TO_created_at = isset($TO_created_at) ? $TO_created_at: "";
		$updated_id = isset($updated_id) ? $updated_id: NULL;
		$updated_at = isset($updated_at) ? $updated_at: "";
		$page = isset($page) ? $page : "";
		$page_len = isset($page_len) ? $page_len : "";
		$query = "select * from {$this->table_name } where 1=1 ";
		if ($id != ""){
			$query .= " and id={$id}";
		}
		if ($photo1 != ""){
			$query .= " and photo1={$photo1}";
		}
		if ($section1 != ""){
			$query .= " and section1={$section1}";
		}
		if ($post_id != ""){
			$query .= " and post_id={$post_id}";
		}
		if ($created_id != ""){
			$query .= " and created_id={$created_id}";
		}
		if ($FROM_created_at != ""){
			$query .= " and DATE(created_at >= DATE('{$FROM_created_at}')";
		}
		if ($TO_created_at != ""){
			$query .= " and DATE(created_at >= DATE('{$TO_created_at}')";
		}
		if ($updated_id != ""){
			$query .= " and updated_id={$updated_id}";
		}
		if ($updated_at != ""){
			$query .= " and updated_at={$updated_at}";
		}
		$page_limit = "";
		if ($page != ""){
			if ($page_len != "" ){
				$this->page_len = $page_len;
			}
			$start = $this->page_len * ((int)$page - 1 );
			$page_limit =" limit {$start},{$this->page_len}";
		}
		$data = [];
		$result = $this->conn->query($query );
		$retrieve_total = $result->rowCount();
		$query .= $page_limit;
		$result = $this->conn->query($query );
		if($result){
			while ($row = $result->fetch(PDO::FETCH_BOTH)){
				$row["posts"] = $this->table_join_data("posts", "id", $row["post_id"]);
				array_push($data, $row );
			}
		}
		return ["total"=> $retrieve_total, "data"=> $data ];
	}
	public function create($params ){
		extract($params );
		$validate = [];
		$id = isset($id) ? $id: NULL;
		$photo1 = isset($photo1) ? $photo1: "";
		$section1 = isset($section1) ? $section1: "";
		$post_id = isset($post_id) ? $post_id: NULL;
		$created_id = isset($created_id) ? $created_id: NULL;
		$created_at = isset($created_at) ? $created_at: "";
		$updated_id = isset($updated_id) ? $updated_id: NULL;
		$updated_at = isset($updated_at) ? $updated_at: "";
		if ($photo1 == ""){
			$validate["photo1"] = "required";
		}
		if ($section1 == ""){
			$validate["section1"] = "required";
		}
		if ($post_id == ""){
			$validate["post_id"] = "required";
		}
		if ($updated_at == ""){
			$validate["updated_at"] = "required";
		}
		if (count($validate ) > 0 ){
			return ["validation"=> $validate, "result"=> false ];
		}
		$query = "insert into {$this->table_name } set ";
		$query .= $photo1 ? " photo1='{$photo1}'" : "";
		$query .= $section1 ? ", section1='{$section1}'" : "";
		$query .= $post_id ? ", post_id={$post_id}" : "";
		$query .= $created_id ? ", created_id={$created_id}" : "";
		$query .= $created_at ? ", created_at='{$created_at}'" : "";
		$query .= $updated_id ? ", updated_id={$updated_id}" : "";
		$query .= $updated_at ? ", updated_at='{$updated_at}'" : "";
$str_pos = strpos($query, " set ,");$query = $str_pos ? substr($query, 0, $str_pos + 5) . substr($query, $str_pos + 7) : $query;		if($this->conn->query($query )){
			return ["validation"=> $validate, "result"=> true ];
		}else{
			return ["validation"=> $validate, "result"=> $this->conn->errorInfo() ];
		}
	}
	public function update($params ){
		extract($params );
		$validate = [];
		$id = isset($id) ? $id: NULL;
		$photo1 = isset($photo1) ? $photo1: "";
		$section1 = isset($section1) ? $section1: "";
		$post_id = isset($post_id) ? $post_id: NULL;
		$created_id = isset($created_id) ? $created_id: NULL;
		$created_at = isset($created_at) ? $created_at: "";
		$updated_id = isset($updated_id) ? $updated_id: NULL;
		$updated_at = isset($updated_at) ? $updated_at: "";
		if ($id == "" ){
			return ["validation"=> $validate, "result"=> "primary key not exist" ];
		}
		$query = "update {$this->table_name } set ";
		$set_arr = [];
		array_push($set_arr, ["field"=> "photo1", "value"=> $photo1, "type"=> "varchar"]);
		array_push($set_arr, ["field"=> "section1", "value"=> $section1, "type"=> "varchar"]);
		array_push($set_arr, ["field"=> "post_id", "value"=> $post_id, "type"=> "int"]);
		array_push($set_arr, ["field"=> "created_id", "value"=> $created_id, "type"=> "int"]);
		array_push($set_arr, ["field"=> "created_at", "value"=> $created_at, "type"=> "datetime"]);
		array_push($set_arr, ["field"=> "updated_id", "value"=> $updated_id, "type"=> "int"]);
		array_push($set_arr, ["field"=> "updated_at", "value"=> $updated_at, "type"=> "timestamp"]);
		$join_query = $this->join_set_data($set_arr );
		$query .= $join_query;
		$query .= " WHERE id={$id}";
if (strlen($join_query) ==0 ){return ["validation"=> [], "result"=> "no date for updating"];}		if($stmt = $this->conn->query($query )){
			return ["validation"=> $validate, "result"=> true, "affected_rows"=> $stmt-rowCount()  ];
		}else{
			return ["validation"=> $validate, "result"=> $this->conn->errorInfo() ];
		}
	}
	public function delete($params ){
		extract($params );
		$validate = [];
		$id = isset($id) ? $id : "";
		if ($id == "" ){
			return ["validation"=> $validate, "result"=> "primary key not exist" ];
		}
		$query = "delete from {$this->table_name} WHERE id={$id}";
		if($stmt = $this->conn->query($query )){
			return ["validation"=> $validate, "result"=> true  ];
		}else{
			return ["validation"=> $validate, "result"=> $this->conn->errorInfo() ];
		}
	}
	public function add_or_update($params ){
		extract($params );
		$id = isset($id) ? $id : "";
		$tmp = [];
		if ($id == "" ){
			$tmp = $this->create($params );
		}else{
			$query = "select * from {$this->table_name} where id={$id}";
			$result = $this->conn->query($query );
			if ($result->rowCount() > 0 ){
				$tmp = $this->update($params );
			}else{
				$tmp = $this->create($params );
			}
		}
		return $tmp;
	}
	private function get_record($id ){
		$query = "select * from {$this->table_name } where id={$id}";
		$result = $this->conn->query($query );
		return $result;
	}
	private function table_join_data($table, $field, $value ){
		$query = "select * from {$table } where {$field}=$value";
		$result = $this->conn->query($query );
		$data = [];
		if($result){
			while ($row = $result->fetch(PDO::FETCH_BOTH)){
				array_push($data, $row );
			}
		}
		return $data;
	}
	private function check_date($string) {
		if (strtotime($string)) {return true;}else {return false;}
	}
	function join_set_data($data ){
		$comma = "";$str = "";
		foreach($data as $item ){
			if(!$item["value"]){ continue;}
			if (strpos($item["type"], "int" ) > -1 || strpos($item["type"], "float" ) > -1 || strpos($item["type"], "double" ) > -1){
				$str .= $comma . $item["field"] . "='" . $item["value"] . "'";
			}else{
				$str .= $comma . $item["field"] . "='" . $item["value"] . "'";
			}
			$comma = ",";
		}
		return $str;
	}
} 
?>