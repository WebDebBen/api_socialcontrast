<?php 
	class SystemAdminPlugins{
	private $conn;
	private $table_name = "system_admin_plugins";
	private $page_len = 10;
	public function __construct($db ){
		$this->conn = $db;
	}
	public function read($params ){
		extract($params );
		$plugin_name = isset($plugin_name) ? $plugin_name: "";
		$status = isset($status) ? $status: "";
		$version_date = isset($version_date) ? $version_date: "";
		$FROM_version_date = isset($FROM_version_date) ? $FROM_version_date: "";
		$TO_version_date = isset($TO_version_date) ? $TO_version_date: "";
		$cre_id = isset($cre_id) ? $cre_id: NULL;
		$date_created = isset($date_created) ? $date_created: "";
		$FROM_date_created = isset($FROM_date_created) ? $FROM_date_created: "";
		$TO_date_created = isset($TO_date_created) ? $TO_date_created: "";
		$upd_id = isset($upd_id) ? $upd_id: NULL;
		$date_updated = isset($date_updated) ? $date_updated: "";
		$FROM_date_updated = isset($FROM_date_updated) ? $FROM_date_updated: "";
		$TO_date_updated = isset($TO_date_updated) ? $TO_date_updated: "";
		$page = isset($page) ? $page : "";
		$page_len = isset($page_len) ? $page_len : "";
		$query = "select * from {$this->table_name } where 1=1 ";
		if ($plugin_name != ""){
			$query .= " and plugin_name={$plugin_name}";
		}
		if ($status != ""){
			$query .= " and status={$status}";
		}
		if ($FROM_version_date != ""){
			$query .= " and DATE(version_date >= DATE('{$FROM_version_date}')";
		}
		if ($TO_version_date != ""){
			$query .= " and DATE(version_date >= DATE('{$TO_version_date}')";
		}
		if ($cre_id != ""){
			$query .= " and cre_id={$cre_id}";
		}
		if ($FROM_date_created != ""){
			$query .= " and DATE(date_created >= DATE('{$FROM_date_created}')";
		}
		if ($TO_date_created != ""){
			$query .= " and DATE(date_created >= DATE('{$TO_date_created}')";
		}
		if ($upd_id != ""){
			$query .= " and upd_id={$upd_id}";
		}
		if ($FROM_date_updated != ""){
			$query .= " and DATE(date_updated >= DATE('{$FROM_date_updated}')";
		}
		if ($TO_date_updated != ""){
			$query .= " and DATE(date_updated >= DATE('{$TO_date_updated}')";
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
		$plugin_name = isset($plugin_name) ? $plugin_name: "";
		$status = isset($status) ? $status: "";
		$version_date = isset($version_date) ? $version_date: "";
		$cre_id = isset($cre_id) ? $cre_id: NULL;
		$date_created = isset($date_created) ? $date_created: "";
		$upd_id = isset($upd_id) ? $upd_id: NULL;
		$date_updated = isset($date_updated) ? $date_updated: "";
		if ($plugin_name == ""){
			$validate["plugin_name"] = "required";
		}
		if ($status == ""){
			$validate["status"] = "required";
		}
		if ($date_created == ""){
			$validate["date_created"] = "required";
		}
		if ($date_updated == ""){
			$validate["date_updated"] = "required";
		}
		if (count($validate ) > 0 ){
			return ["validation"=> $validate, "result"=> false ];
		}
		$query = "insert into {$this->table_name } set ";
		$query .= $plugin_name ? " plugin_name='{$plugin_name}'" : "";
		$query .= $status ? ", status='{$status}'" : "";
		$query .= $version_date ? ", version_date='{$version_date}'" : "";
		$query .= $cre_id ? ", cre_id={$cre_id}" : "";
		$query .= $date_created ? ", date_created='{$date_created}'" : "";
		$query .= $upd_id ? ", upd_id={$upd_id}" : "";
		$query .= $date_updated ? ", date_updated='{$date_updated}'" : "";
$str_pos = strpos($query, " set ,");$query = $str_pos ? substr($query, 0, $str_pos + 5) . substr($query, $str_pos + 7) : $query;		if($this->conn->query($query )){
			return ["validation"=> $validate, "result"=> true ];
		}else{
			return ["validation"=> $validate, "result"=> $this->conn->errorInfo() ];
		}
	}
	public function update($params ){
		extract($params );
		$validate = [];
		$plugin_name = isset($plugin_name) ? $plugin_name: "";
		$status = isset($status) ? $status: "";
		$version_date = isset($version_date) ? $version_date: "";
		$cre_id = isset($cre_id) ? $cre_id: NULL;
		$date_created = isset($date_created) ? $date_created: "";
		$upd_id = isset($upd_id) ? $upd_id: NULL;
		$date_updated = isset($date_updated) ? $date_updated: "";
		if ($plugin_name == "" ){
			return ["validation"=> $validate, "result"=> "primary key not exist" ];
		}
		$query = "update {$this->table_name } set ";
		$set_arr = [];
		array_push($set_arr, ["field"=> "plugin_name", "value"=> $plugin_name, "type"=> "varchar"]);
		array_push($set_arr, ["field"=> "status", "value"=> $status, "type"=> "enum"]);
		array_push($set_arr, ["field"=> "version_date", "value"=> $version_date, "type"=> "date"]);
		array_push($set_arr, ["field"=> "cre_id", "value"=> $cre_id, "type"=> "int"]);
		array_push($set_arr, ["field"=> "date_created", "value"=> $date_created, "type"=> "datetime"]);
		array_push($set_arr, ["field"=> "upd_id", "value"=> $upd_id, "type"=> "int"]);
		array_push($set_arr, ["field"=> "date_updated", "value"=> $date_updated, "type"=> "datetime"]);
		$join_query = $this->join_set_data($set_arr );
		$query .= $join_query;
		$query .= " WHERE plugin_name={$plugin_name}";
if (strlen($join_query) ==0 ){return ["validation"=> [], "result"=> "no date for updating"];}		if($stmt = $this->conn->query($query )){
			return ["validation"=> $validate, "result"=> true, "affected_rows"=> $stmt-rowCount()  ];
		}else{
			return ["validation"=> $validate, "result"=> $this->conn->errorInfo() ];
		}
	}
	public function delete($params ){
		extract($params );
		$validate = [];
		$plugin_name = isset($plugin_name) ? $plugin_name : "";
		if ($plugin_name == "" ){
			return ["validation"=> $validate, "result"=> "primary key not exist" ];
		}
		$query = "delete from {$this->table_name} WHERE plugin_name={$plugin_name}";
		if($stmt = $this->conn->query($query )){
			return ["validation"=> $validate, "result"=> true  ];
		}else{
			return ["validation"=> $validate, "result"=> $this->conn->errorInfo() ];
		}
	}
	public function add_or_update($params ){
		extract($params );
		$plugin_name = isset($plugin_name) ? $plugin_name : "";
		$tmp = [];
		if ($plugin_name == "" ){
			$tmp = $this->create($params );
		}else{
			$query = "select * from {$this->table_name} where plugin_name={$plugin_name}";
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
		$query = "select * from {$this->table_name } where plugin_name={$id}";
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