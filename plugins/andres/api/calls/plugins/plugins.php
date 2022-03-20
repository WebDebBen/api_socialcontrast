<?php 
	class Plugins{
	private $conn;
	private $table_name = "plugins";
	private $page_len = 10;
	public function __construct($db ){
		$this->conn = $db;
	}
	public function read($params ){
		extract($params );
		$PLUGIN_NAME = isset($PLUGIN_NAME) ? $PLUGIN_NAME: "";
		$id = isset($id) ? $id: NULL;
		$PLUGIN_VERSION = isset($PLUGIN_VERSION) ? $PLUGIN_VERSION: "";
		$name = isset($name) ? $name: "";
		$PLUGIN_STATUS = isset($PLUGIN_STATUS) ? $PLUGIN_STATUS: "";
		$PLUGIN_TYPE = isset($PLUGIN_TYPE) ? $PLUGIN_TYPE: "";
		$PLUGIN_TYPE_VERSION = isset($PLUGIN_TYPE_VERSION) ? $PLUGIN_TYPE_VERSION: "";
		$PLUGIN_LIBRARY = isset($PLUGIN_LIBRARY) ? $PLUGIN_LIBRARY: "";
		$PLUGIN_LIBRARY_VERSION = isset($PLUGIN_LIBRARY_VERSION) ? $PLUGIN_LIBRARY_VERSION: "";
		$PLUGIN_AUTHOR = isset($PLUGIN_AUTHOR) ? $PLUGIN_AUTHOR: "";
		$PLUGIN_DESCRIPTION = isset($PLUGIN_DESCRIPTION) ? $PLUGIN_DESCRIPTION: "";
		$PLUGIN_LICENSE = isset($PLUGIN_LICENSE) ? $PLUGIN_LICENSE: "";
		$LOAD_OPTION = isset($LOAD_OPTION) ? $LOAD_OPTION: "";
		$PLUGIN_MATURITY = isset($PLUGIN_MATURITY) ? $PLUGIN_MATURITY: "";
		$PLUGIN_AUTH_VERSION = isset($PLUGIN_AUTH_VERSION) ? $PLUGIN_AUTH_VERSION: "";
		$page = isset($page) ? $page : "";
		$page_len = isset($page_len) ? $page_len : "";
		$query = "select * from {$this->table_name } where 1=1 ";
		if ($PLUGIN_NAME != ""){
			$query .= " and PLUGIN_NAME={$PLUGIN_NAME}";
		}
		if ($id != ""){
			$query .= " and id={$id}";
		}
		if ($PLUGIN_VERSION != ""){
			$query .= " and PLUGIN_VERSION={$PLUGIN_VERSION}";
		}
		if ($name != ""){
			$query .= " and name={$name}";
		}
		if ($PLUGIN_STATUS != ""){
			$query .= " and PLUGIN_STATUS={$PLUGIN_STATUS}";
		}
		if ($PLUGIN_TYPE != ""){
			$query .= " and PLUGIN_TYPE={$PLUGIN_TYPE}";
		}
		if ($PLUGIN_TYPE_VERSION != ""){
			$query .= " and PLUGIN_TYPE_VERSION={$PLUGIN_TYPE_VERSION}";
		}
		if ($PLUGIN_LIBRARY != ""){
			$query .= " and PLUGIN_LIBRARY={$PLUGIN_LIBRARY}";
		}
		if ($PLUGIN_LIBRARY_VERSION != ""){
			$query .= " and PLUGIN_LIBRARY_VERSION={$PLUGIN_LIBRARY_VERSION}";
		}
		if ($PLUGIN_AUTHOR != ""){
			$query .= " and PLUGIN_AUTHOR={$PLUGIN_AUTHOR}";
		}
		if ($PLUGIN_DESCRIPTION != ""){
			$query .= " and PLUGIN_DESCRIPTION={$PLUGIN_DESCRIPTION}";
		}
		if ($PLUGIN_LICENSE != ""){
			$query .= " and PLUGIN_LICENSE={$PLUGIN_LICENSE}";
		}
		if ($LOAD_OPTION != ""){
			$query .= " and LOAD_OPTION={$LOAD_OPTION}";
		}
		if ($PLUGIN_MATURITY != ""){
			$query .= " and PLUGIN_MATURITY={$PLUGIN_MATURITY}";
		}
		if ($PLUGIN_AUTH_VERSION != ""){
			$query .= " and PLUGIN_AUTH_VERSION={$PLUGIN_AUTH_VERSION}";
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
		$PLUGIN_NAME = isset($PLUGIN_NAME) ? $PLUGIN_NAME: "";
		$id = isset($id) ? $id: NULL;
		$PLUGIN_VERSION = isset($PLUGIN_VERSION) ? $PLUGIN_VERSION: "";
		$name = isset($name) ? $name: "";
		$PLUGIN_STATUS = isset($PLUGIN_STATUS) ? $PLUGIN_STATUS: "";
		$PLUGIN_TYPE = isset($PLUGIN_TYPE) ? $PLUGIN_TYPE: "";
		$PLUGIN_TYPE_VERSION = isset($PLUGIN_TYPE_VERSION) ? $PLUGIN_TYPE_VERSION: "";
		$PLUGIN_LIBRARY = isset($PLUGIN_LIBRARY) ? $PLUGIN_LIBRARY: "";
		$PLUGIN_LIBRARY_VERSION = isset($PLUGIN_LIBRARY_VERSION) ? $PLUGIN_LIBRARY_VERSION: "";
		$PLUGIN_AUTHOR = isset($PLUGIN_AUTHOR) ? $PLUGIN_AUTHOR: "";
		$PLUGIN_DESCRIPTION = isset($PLUGIN_DESCRIPTION) ? $PLUGIN_DESCRIPTION: "";
		$PLUGIN_LICENSE = isset($PLUGIN_LICENSE) ? $PLUGIN_LICENSE: "";
		$LOAD_OPTION = isset($LOAD_OPTION) ? $LOAD_OPTION: "";
		$PLUGIN_MATURITY = isset($PLUGIN_MATURITY) ? $PLUGIN_MATURITY: "";
		$PLUGIN_AUTH_VERSION = isset($PLUGIN_AUTH_VERSION) ? $PLUGIN_AUTH_VERSION: "";
		if ($PLUGIN_NAME == ""){
			$validate["PLUGIN_NAME"] = "required";
		}
		if ($PLUGIN_VERSION == ""){
			$validate["PLUGIN_VERSION"] = "required";
		}
		if ($PLUGIN_STATUS == ""){
			$validate["PLUGIN_STATUS"] = "required";
		}
		if ($PLUGIN_TYPE == ""){
			$validate["PLUGIN_TYPE"] = "required";
		}
		if ($PLUGIN_TYPE_VERSION == ""){
			$validate["PLUGIN_TYPE_VERSION"] = "required";
		}
		if ($PLUGIN_LICENSE == ""){
			$validate["PLUGIN_LICENSE"] = "required";
		}
		if ($LOAD_OPTION == ""){
			$validate["LOAD_OPTION"] = "required";
		}
		if ($PLUGIN_MATURITY == ""){
			$validate["PLUGIN_MATURITY"] = "required";
		}
		if (count($validate ) > 0 ){
			return ["validation"=> $validate, "result"=> false ];
		}
		$query = "insert into {$this->table_name } set ";
		$query .= $PLUGIN_NAME ? " PLUGIN_NAME='{$PLUGIN_NAME}'" : "";
		$query .= $PLUGIN_VERSION ? ", PLUGIN_VERSION='{$PLUGIN_VERSION}'" : "";
		$query .= $name ? ", name='{$name}'" : "";
		$query .= $PLUGIN_STATUS ? ", PLUGIN_STATUS='{$PLUGIN_STATUS}'" : "";
		$query .= $PLUGIN_TYPE ? ", PLUGIN_TYPE='{$PLUGIN_TYPE}'" : "";
		$query .= $PLUGIN_TYPE_VERSION ? ", PLUGIN_TYPE_VERSION='{$PLUGIN_TYPE_VERSION}'" : "";
		$query .= $PLUGIN_LIBRARY ? ", PLUGIN_LIBRARY='{$PLUGIN_LIBRARY}'" : "";
		$query .= $PLUGIN_LIBRARY_VERSION ? ", PLUGIN_LIBRARY_VERSION='{$PLUGIN_LIBRARY_VERSION}'" : "";
		$query .= $PLUGIN_AUTHOR ? ", PLUGIN_AUTHOR='{$PLUGIN_AUTHOR}'" : "";
		$query .= $PLUGIN_DESCRIPTION ? ", PLUGIN_DESCRIPTION='{$PLUGIN_DESCRIPTION}'" : "";
		$query .= $PLUGIN_LICENSE ? ", PLUGIN_LICENSE='{$PLUGIN_LICENSE}'" : "";
		$query .= $LOAD_OPTION ? ", LOAD_OPTION='{$LOAD_OPTION}'" : "";
		$query .= $PLUGIN_MATURITY ? ", PLUGIN_MATURITY='{$PLUGIN_MATURITY}'" : "";
		$query .= $PLUGIN_AUTH_VERSION ? ", PLUGIN_AUTH_VERSION='{$PLUGIN_AUTH_VERSION}'" : "";
$str_pos = strpos($query, " set ,");$query = $str_pos ? substr($query, 0, $str_pos + 5) . substr($query, $str_pos + 7) : $query;		if($this->conn->query($query )){
			return ["validation"=> $validate, "result"=> true ];
		}else{
			return ["validation"=> $validate, "result"=> $this->conn->errorInfo() ];
		}
	}
	public function update($params ){
		extract($params );
		$validate = [];
		$PLUGIN_NAME = isset($PLUGIN_NAME) ? $PLUGIN_NAME: "";
		$id = isset($id) ? $id: NULL;
		$PLUGIN_VERSION = isset($PLUGIN_VERSION) ? $PLUGIN_VERSION: "";
		$name = isset($name) ? $name: "";
		$PLUGIN_STATUS = isset($PLUGIN_STATUS) ? $PLUGIN_STATUS: "";
		$PLUGIN_TYPE = isset($PLUGIN_TYPE) ? $PLUGIN_TYPE: "";
		$PLUGIN_TYPE_VERSION = isset($PLUGIN_TYPE_VERSION) ? $PLUGIN_TYPE_VERSION: "";
		$PLUGIN_LIBRARY = isset($PLUGIN_LIBRARY) ? $PLUGIN_LIBRARY: "";
		$PLUGIN_LIBRARY_VERSION = isset($PLUGIN_LIBRARY_VERSION) ? $PLUGIN_LIBRARY_VERSION: "";
		$PLUGIN_AUTHOR = isset($PLUGIN_AUTHOR) ? $PLUGIN_AUTHOR: "";
		$PLUGIN_DESCRIPTION = isset($PLUGIN_DESCRIPTION) ? $PLUGIN_DESCRIPTION: "";
		$PLUGIN_LICENSE = isset($PLUGIN_LICENSE) ? $PLUGIN_LICENSE: "";
		$LOAD_OPTION = isset($LOAD_OPTION) ? $LOAD_OPTION: "";
		$PLUGIN_MATURITY = isset($PLUGIN_MATURITY) ? $PLUGIN_MATURITY: "";
		$PLUGIN_AUTH_VERSION = isset($PLUGIN_AUTH_VERSION) ? $PLUGIN_AUTH_VERSION: "";
		if ($id == "" ){
			return ["validation"=> $validate, "result"=> "primary key not exist" ];
		}
		$query = "update {$this->table_name } set ";
		$set_arr = [];
		array_push($set_arr, ["field"=> "PLUGIN_NAME", "value"=> $PLUGIN_NAME, "type"=> "varchar"]);
		array_push($set_arr, ["field"=> "PLUGIN_VERSION", "value"=> $PLUGIN_VERSION, "type"=> "varchar"]);
		array_push($set_arr, ["field"=> "name", "value"=> $name, "type"=> "varchar"]);
		array_push($set_arr, ["field"=> "PLUGIN_STATUS", "value"=> $PLUGIN_STATUS, "type"=> "varchar"]);
		array_push($set_arr, ["field"=> "PLUGIN_TYPE", "value"=> $PLUGIN_TYPE, "type"=> "varchar"]);
		array_push($set_arr, ["field"=> "PLUGIN_TYPE_VERSION", "value"=> $PLUGIN_TYPE_VERSION, "type"=> "varchar"]);
		array_push($set_arr, ["field"=> "PLUGIN_LIBRARY", "value"=> $PLUGIN_LIBRARY, "type"=> "varchar"]);
		array_push($set_arr, ["field"=> "PLUGIN_LIBRARY_VERSION", "value"=> $PLUGIN_LIBRARY_VERSION, "type"=> "varchar"]);
		array_push($set_arr, ["field"=> "PLUGIN_AUTHOR", "value"=> $PLUGIN_AUTHOR, "type"=> "varchar"]);
		array_push($set_arr, ["field"=> "PLUGIN_DESCRIPTION", "value"=> $PLUGIN_DESCRIPTION, "type"=> "longtext"]);
		array_push($set_arr, ["field"=> "PLUGIN_LICENSE", "value"=> $PLUGIN_LICENSE, "type"=> "varchar"]);
		array_push($set_arr, ["field"=> "LOAD_OPTION", "value"=> $LOAD_OPTION, "type"=> "varchar"]);
		array_push($set_arr, ["field"=> "PLUGIN_MATURITY", "value"=> $PLUGIN_MATURITY, "type"=> "varchar"]);
		array_push($set_arr, ["field"=> "PLUGIN_AUTH_VERSION", "value"=> $PLUGIN_AUTH_VERSION, "type"=> "varchar"]);
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