<?php 
	class Commits{
	private $conn;
	private $table_name = "commits";
	private $page_len = 10;
	public function __construct($db ){
		$this->conn = $db;
	}
	public function read($params ){
		extract($params );
		$id = isset($id) ? $id: NULL;
		$id = isset($id) ? $id: NULL;
		$plugin_name = isset($plugin_name) ? $plugin_name: "";
		$name = isset($name) ? $name: "";
		$name = isset($name) ? $name: "";
		$description = isset($description) ? $description: "";
		$description = isset($description) ? $description: "";
		$created_at = isset($created_at) ? $created_at: "";
		$created_at = isset($created_at) ? $created_at: "";
		$is_commited = isset($is_commited) ? $is_commited: NULL;
		$page = isset($page) ? $page : "";
		$page_len = isset($page_len) ? $page_len : "";
		$query = "select * from {$this->table_name } where 1=1 ";
		if ($id != ""){
			$query .= " and id={$id}";
		}
		if ($id != ""){
			$query .= " and id={$id}";
		}
		if ($plugin_name != ""){
			$query .= " and plugin_name={$plugin_name}";
		}
		if ($name != ""){
			$query .= " and name={$name}";
		}
		if ($name != ""){
			$query .= " and name={$name}";
		}
		if ($description != ""){
			$query .= " and description={$description}";
		}
		if ($description != ""){
			$query .= " and description={$description}";
		}
		if ($created_at != ""){
			$query .= " and created_at={$created_at}";
		}
		if ($created_at != ""){
			$query .= " and created_at={$created_at}";
		}
		if ($is_commited != ""){
			$query .= " and is_commited={$is_commited}";
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
				array_push($data, $row );
			}
		}
		return ["total"=> $retrieve_total, "data"=> $data ];
	}
	public function create($params ){
		extract($params );
		$validate = [];
		$id = isset($id) ? $id: NULL;
		$id = isset($id) ? $id: NULL;
		$plugin_name = isset($plugin_name) ? $plugin_name: "";
		$name = isset($name) ? $name: "";
		$name = isset($name) ? $name: "";
		$description = isset($description) ? $description: "";
		$description = isset($description) ? $description: "";
		$created_at = isset($created_at) ? $created_at: "";
		$created_at = isset($created_at) ? $created_at: "";
		$is_commited = isset($is_commited) ? $is_commited: NULL;
		if (count($validate ) > 0 ){
			return ["validation"=> $validate, "result"=> false ];
		}
		$query = "insert into {$this->table_name } set ";
		$query .= $plugin_name ? " plugin_name='{$plugin_name}'" : "";
		$query .= $name ? ", name='{$name}'" : "";
		$query .= $description ? ", description='{$description}'" : "";
		$query .= $created_at ? ", created_at='{$created_at}'" : "";
		$query .= $is_commited ? ", is_commited={$is_commited}" : "";
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
		$id = isset($id) ? $id: NULL;
		$plugin_name = isset($plugin_name) ? $plugin_name: "";
		$name = isset($name) ? $name: "";
		$name = isset($name) ? $name: "";
		$description = isset($description) ? $description: "";
		$description = isset($description) ? $description: "";
		$created_at = isset($created_at) ? $created_at: "";
		$created_at = isset($created_at) ? $created_at: "";
		$is_commited = isset($is_commited) ? $is_commited: NULL;
		if ($id == "" ){
			return ["validation"=> $validate, "result"=> "primary key not exist" ];
		}
		$query = "update {$this->table_name } set ";
		$set_arr = [];
		array_push($set_arr, ["field"=> "plugin_name", "value"=> $plugin_name, "type"=> "varchar"]);
		array_push($set_arr, ["field"=> "name", "value"=> $name, "type"=> "varchar"]);
		array_push($set_arr, ["field"=> "description", "value"=> $description, "type"=> "varchar"]);
		array_push($set_arr, ["field"=> "created_at", "value"=> $created_at, "type"=> "timestamp"]);
		array_push($set_arr, ["field"=> "is_commited", "value"=> $is_commited, "type"=> "int"]);
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