<?php 
	class Books{
	private $conn;
	private $table_name = "books";
	private $page_len = 10;
	public function __construct($db ){
		$this->conn = $db;
	}
	public function read($params ){
		extract($params );
		$id = isset($id) ? $id: NULL;
		$book_name = isset($book_name) ? $book_name: "";
		$publish_year = isset($publish_year) ? $publish_year: NULL;
		$author = isset($author) ? $author: "";
		$bigo = isset($bigo) ? $bigo: "";
		$note = isset($note) ? $note: "";
		$enumb = isset($enumb) ? $enumb: "";
		$page = isset($page) ? $page : "";
		$page_len = isset($page_len) ? $page_len : "";
		$query = "select * from {$this->table_name } where 1=1 ";
		if ($id != ""){
			$query .= " and id={$id}";
		}
		if ($book_name != ""){
			$query .= " and book_name={$book_name}";
		}
		if ($publish_year != ""){
			$query .= " and publish_year={$publish_year}";
		}
		if ($author != ""){
			$query .= " and author={$author}";
		}
		if ($bigo != ""){
			$query .= " and bigo={$bigo}";
		}
		if ($note != ""){
			$query .= " and note={$note}";
		}
		if ($enumb != ""){
			$query .= " and enumb={$enumb}";
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
		$book_name = isset($book_name) ? $book_name: "";
		$publish_year = isset($publish_year) ? $publish_year: NULL;
		$author = isset($author) ? $author: "";
		$bigo = isset($bigo) ? $bigo: "";
		$note = isset($note) ? $note: "";
		$enumb = isset($enumb) ? $enumb: "";
		if ($book_name == ""){
			$validate["book_name"] = "required";
		}
		if ($publish_year == ""){
			$validate["publish_year"] = "required";
		}
		if ($author == ""){
			$validate["author"] = "required";
		}
		if ($bigo == ""){
			$validate["bigo"] = "required";
		}
		if ($note == ""){
			$validate["note"] = "required";
		}
		if ($enumb == ""){
			$validate["enumb"] = "required";
		}
		if (count($validate ) > 0 ){
			return ["validation"=> $validate, "result"=> false ];
		}
		$query = "insert into {$this->table_name } set ";
		$query .= $book_name ? " book_name='{$book_name}'" : "";
		$query .= $publish_year ? ", publish_year={$publish_year}" : "";
		$query .= $author ? ", author='{$author}'" : "";
		$query .= $bigo ? ", bigo='{$bigo}'" : "";
		$query .= $note ? ", note='{$note}'" : "";
		$query .= $enumb ? ", enumb='{$enumb}'" : "";
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
		$book_name = isset($book_name) ? $book_name: "";
		$publish_year = isset($publish_year) ? $publish_year: NULL;
		$author = isset($author) ? $author: "";
		$bigo = isset($bigo) ? $bigo: "";
		$note = isset($note) ? $note: "";
		$enumb = isset($enumb) ? $enumb: "";
		if ($id == "" ){
			return ["validation"=> $validate, "result"=> "primary key not exist" ];
		}
		$query = "update {$this->table_name } set ";
		$set_arr = [];
		array_push($set_arr, ["field"=> "book_name", "value"=> $book_name, "type"=> "varchar"]);
		array_push($set_arr, ["field"=> "publish_year", "value"=> $publish_year, "type"=> "int"]);
		array_push($set_arr, ["field"=> "author", "value"=> $author, "type"=> "varchar"]);
		array_push($set_arr, ["field"=> "bigo", "value"=> $bigo, "type"=> "varchar"]);
		array_push($set_arr, ["field"=> "note", "value"=> $note, "type"=> "text"]);
		array_push($set_arr, ["field"=> "enumb", "value"=> $enumb, "type"=> "enum"]);
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