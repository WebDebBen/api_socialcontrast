<?php 
	class Admins{
	private $conn;
	private $table_name = "admins";
	private $page_len = 10;
	public function __construct($db ){
		$this->conn = $db;
	}
	public function read($params ){
		extract($params );
		$id = isset($id) ? $id: NULL;
		$username = isset($username) ? $username: "";
		$password = isset($password) ? $password: "";
		$pos_enabled = isset($pos_enabled) ? $pos_enabled: NULL;
		$stocktaking_enabled = isset($stocktaking_enabled) ? $stocktaking_enabled: NULL;
		$crm_enabled = isset($crm_enabled) ? $crm_enabled: NULL;
		$settings_enabled = isset($settings_enabled) ? $settings_enabled: NULL;
		$salesman_id = isset($salesman_id) ? $salesman_id: NULL;
		$last_login_datetime = isset($last_login_datetime) ? $last_login_datetime: "";
		$FROM_last_login_datetime = isset($FROM_last_login_datetime) ? $FROM_last_login_datetime: "";
		$TO_last_login_datetime = isset($TO_last_login_datetime) ? $TO_last_login_datetime: "";
		$active = isset($active) ? $active: NULL;
		$cre_id = isset($cre_id) ? $cre_id: NULL;
		$created_date = isset($created_date) ? $created_date: "";
		$FROM_created_date = isset($FROM_created_date) ? $FROM_created_date: "";
		$TO_created_date = isset($TO_created_date) ? $TO_created_date: "";
		$last_upd_date = isset($last_upd_date) ? $last_upd_date: "";
		$FROM_last_upd_date = isset($FROM_last_upd_date) ? $FROM_last_upd_date: "";
		$TO_last_upd_date = isset($TO_last_upd_date) ? $TO_last_upd_date: "";
		$last_upd_id = isset($last_upd_id) ? $last_upd_id: NULL;
		$page = isset($page) ? $page : "";
		$page_len = isset($page_len) ? $page_len : "";
		$query = "select * from {$this->table_name } where 1=1 ";
		if ($id != ""){
			$query .= " and id={$id}";
		}
		if ($username != ""){
			$query .= " and username={$username}";
		}
		if ($password != ""){
			$query .= " and password={$password}";
		}
		if ($pos_enabled != ""){
			$query .= " and pos_enabled={$pos_enabled}";
		}
		if ($stocktaking_enabled != ""){
			$query .= " and stocktaking_enabled={$stocktaking_enabled}";
		}
		if ($crm_enabled != ""){
			$query .= " and crm_enabled={$crm_enabled}";
		}
		if ($settings_enabled != ""){
			$query .= " and settings_enabled={$settings_enabled}";
		}
		if ($salesman_id != ""){
			$query .= " and salesman_id={$salesman_id}";
		}
		if ($FROM_last_login_datetime != ""){
			$query .= " and DATE(last_login_datetime >= DATE('{$FROM_last_login_datetime}')";
		}
		if ($TO_last_login_datetime != ""){
			$query .= " and DATE(last_login_datetime >= DATE('{$TO_last_login_datetime}')";
		}
		if ($active != ""){
			$query .= " and active={$active}";
		}
		if ($cre_id != ""){
			$query .= " and cre_id={$cre_id}";
		}
		if ($FROM_created_date != ""){
			$query .= " and DATE(created_date >= DATE('{$FROM_created_date}')";
		}
		if ($TO_created_date != ""){
			$query .= " and DATE(created_date >= DATE('{$TO_created_date}')";
		}
		if ($FROM_last_upd_date != ""){
			$query .= " and DATE(last_upd_date >= DATE('{$FROM_last_upd_date}')";
		}
		if ($TO_last_upd_date != ""){
			$query .= " and DATE(last_upd_date >= DATE('{$TO_last_upd_date}')";
		}
		if ($last_upd_id != ""){
			$query .= " and last_upd_id={$last_upd_id}";
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
		$username = isset($username) ? $username: "";
		$password = isset($password) ? $password: "";
		$pos_enabled = isset($pos_enabled) ? $pos_enabled: NULL;
		$stocktaking_enabled = isset($stocktaking_enabled) ? $stocktaking_enabled: NULL;
		$crm_enabled = isset($crm_enabled) ? $crm_enabled: NULL;
		$settings_enabled = isset($settings_enabled) ? $settings_enabled: NULL;
		$salesman_id = isset($salesman_id) ? $salesman_id: NULL;
		$last_login_datetime = isset($last_login_datetime) ? $last_login_datetime: "";
		$active = isset($active) ? $active: NULL;
		$cre_id = isset($cre_id) ? $cre_id: NULL;
		$created_date = isset($created_date) ? $created_date: "";
		$last_upd_date = isset($last_upd_date) ? $last_upd_date: "";
		$last_upd_id = isset($last_upd_id) ? $last_upd_id: NULL;
		if ($stocktaking_enabled == ""){
			$validate["stocktaking_enabled"] = "required";
		}
		if ($settings_enabled == ""){
			$validate["settings_enabled"] = "required";
		}
		if ($last_login_datetime == ""){
			$validate["last_login_datetime"] = "required";
		}
		if ($active == ""){
			$validate["active"] = "required";
		}
		if ($last_upd_date == ""){
			$validate["last_upd_date"] = "required";
		}
		if (count($validate ) > 0 ){
			return ["validation"=> $validate, "result"=> false ];
		}
		$query = "insert into {$this->table_name } set ";
		$query .= $username ? " username='{$username}'" : "";
		$query .= $password ? ", password='{$password}'" : "";
		$query .= $pos_enabled ? ", pos_enabled={$pos_enabled}" : "";
		$query .= $stocktaking_enabled ? ", stocktaking_enabled={$stocktaking_enabled}" : "";
		$query .= $crm_enabled ? ", crm_enabled={$crm_enabled}" : "";
		$query .= $settings_enabled ? ", settings_enabled={$settings_enabled}" : "";
		$query .= $salesman_id ? ", salesman_id={$salesman_id}" : "";
		$query .= $last_login_datetime ? ", last_login_datetime='{$last_login_datetime}'" : "";
		$query .= $active ? ", active={$active}" : "";
		$query .= $cre_id ? ", cre_id={$cre_id}" : "";
		$query .= $created_date ? ", created_date='{$created_date}'" : "";
		$query .= $last_upd_date ? ", last_upd_date='{$last_upd_date}'" : "";
		$query .= $last_upd_id ? ", last_upd_id={$last_upd_id}" : "";
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
		$username = isset($username) ? $username: "";
		$password = isset($password) ? $password: "";
		$pos_enabled = isset($pos_enabled) ? $pos_enabled: NULL;
		$stocktaking_enabled = isset($stocktaking_enabled) ? $stocktaking_enabled: NULL;
		$crm_enabled = isset($crm_enabled) ? $crm_enabled: NULL;
		$settings_enabled = isset($settings_enabled) ? $settings_enabled: NULL;
		$salesman_id = isset($salesman_id) ? $salesman_id: NULL;
		$last_login_datetime = isset($last_login_datetime) ? $last_login_datetime: "";
		$active = isset($active) ? $active: NULL;
		$cre_id = isset($cre_id) ? $cre_id: NULL;
		$created_date = isset($created_date) ? $created_date: "";
		$last_upd_date = isset($last_upd_date) ? $last_upd_date: "";
		$last_upd_id = isset($last_upd_id) ? $last_upd_id: NULL;
		if ($id == "" ){
			return ["validation"=> $validate, "result"=> "primary key not exist" ];
		}
		$query = "update {$this->table_name } set ";
		$set_arr = [];
		array_push($set_arr, ["field"=> "username", "value"=> $username, "type"=> "varchar"]);
		array_push($set_arr, ["field"=> "password", "value"=> $password, "type"=> "varchar"]);
		array_push($set_arr, ["field"=> "pos_enabled", "value"=> $pos_enabled, "type"=> "tinyint"]);
		array_push($set_arr, ["field"=> "stocktaking_enabled", "value"=> $stocktaking_enabled, "type"=> "tinyint"]);
		array_push($set_arr, ["field"=> "crm_enabled", "value"=> $crm_enabled, "type"=> "tinyint"]);
		array_push($set_arr, ["field"=> "settings_enabled", "value"=> $settings_enabled, "type"=> "tinyint"]);
		array_push($set_arr, ["field"=> "salesman_id", "value"=> $salesman_id, "type"=> "int"]);
		array_push($set_arr, ["field"=> "last_login_datetime", "value"=> $last_login_datetime, "type"=> "datetime"]);
		array_push($set_arr, ["field"=> "active", "value"=> $active, "type"=> "tinyint"]);
		array_push($set_arr, ["field"=> "cre_id", "value"=> $cre_id, "type"=> "int"]);
		array_push($set_arr, ["field"=> "created_date", "value"=> $created_date, "type"=> "datetime"]);
		array_push($set_arr, ["field"=> "last_upd_date", "value"=> $last_upd_date, "type"=> "datetime"]);
		array_push($set_arr, ["field"=> "last_upd_id", "value"=> $last_upd_id, "type"=> "int"]);
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