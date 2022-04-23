<?php
include_once '../../../../config/config.php';
include_once '../../../../config/database.php';

$db = new Database();
$db->getConnection(API_DB_NAME );

extract($_POST );
switch($type ){
    case "table_list":
        load_dt_table_list();
        break;
    case "table_info":
        load_dt_table_info($table_name, $plugin_name);
        break;
    case "save_table":
        save_dt_table_data($id, $table_name, $table_data );
        break;
    case "load_data":
        load_dt_table_data($id, $table_name);
        break;
    case "delete_data":
        delete_dt_table_data($id, $table_name);
        break;
    case "load_relation_data":
        load_relation_data($table_name, $table_field, $ref_table_name, $ref_table_field);
        break;
}

function load_relation_data($table_name, $table_field, $ref_table_name, $ref_table_field){
    $db = $GLOBALS["db"];
    //$query = "select {$ref_table_name}.* from {$table_name} 
    //            left join {$ref_table_name} on {$table_name}.{$table_field} = {$ref_table_name}.{$ref_table_field}";
    $query = "select * from {$ref_table_name}";
    $result = $db->load_records_data($query );
    echo json_encode(["status"=>"success", "result"=>$result]);
}

function delete_dt_table_data($id, $table_name){
    $query = "delete from {$table_name} where id = {$id}";
    $db = $GLOBALS["db"];
    $db->run_query($query);
    echo json_encode(["status"=> "success"]);
}

function load_dt_table_data($id, $table_name){
    $db = $GLOBALS["db"];
    $table_info = $db->table_info($table_name );
    $query = "select * from {$table_name} where id={$id}";
    $result = $db->load_records($query);
    $item = [];
	if($result){
        while ($row = $result->fetch(PDO::FETCH_BOTH)){
			foreach($table_info["columns"] as $col){
                $title = $col["column_name"];
                $item[$title] = $row[$title];
            }
		}
	}
    echo json_encode(["status"=> "success", "data"=>$item ]);
}

function save_dt_table_data($id, $table_name, $table_data ){
    $query = "";
    if ($id == ""){
        $flag = false;
        $query = "insert into {$table_name} set ";
        foreach($table_data as $key=> $value){
            if ($key != "id"){
                if ($flag == false){
                    $flag = true;
                    $query .= " {$key}='{$value}'";
                }else{
                    $query .= " , {$key}='{$value}'";
                }
            }
        }
    }else{
        $query = "update {$table_name} set ";
        $flag = false;
        foreach($table_data as $key=> $value){
            if ($flag == false){
                $flag = true;
                $query .= " {$key}='{$value}'";
            }else{
                $query .= " , {$key}='{$value}'";
            }
        }
        $query .= " where id={$id}"; 
    }
    $db = $GLOBALS["db"];
    $last_insert_id = $db->run_query($query );
    echo json_encode(["status"=> "success", "id"=> $last_insert_id]);
}

function load_dt_table_info($table_name, $plugin_name){
    $db = $GLOBALS["db"];
    $table_info = $db->table_info($table_name );
    
    $json_path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/{$plugin_name}/settings/tables/{$table_name}.json";
    $json_data = [];
    if (file_exists($json_path)){
        $json_data = json_decode(file_get_contents($json_path));
    }

    // get table data
	$result = $db->load_data($table_name);
    $table_data = [];
	if($result){
		while ($row = $result->fetch(PDO::FETCH_ASSOC)){
            $item = [];
            foreach($row as $key=>$value){
                $item[$key] = $value;
            }
            array_push($table_data, $item );
		}
	}

    echo  json_encode(["status"=> "success", "table_info"=> $table_info, "table_data"=> $table_data, "json_data"=> $json_data]);
}

function load_dt_table_list(){
    $db = $GLOBALS["db"];

    $result = ["status"=> "success"];
    $data = $db->show_tables();
    $result["data"] = $data;
    echo json_encode($result );
}

?>