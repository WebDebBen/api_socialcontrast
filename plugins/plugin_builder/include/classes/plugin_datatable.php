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
}

function load_dt_table_info($table_name, $plugin_name){
    $db = $GLOBALS["db"];
    $table_info = $db->table_info($table_name );
    
    $json_path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/plugin_creator/{$plugin_name}/settings/tables/{$table_name}.json";
    $json_data = [];
    if (file_exists($json_path)){
        $json_data = json_decode(file_get_contents($json_path));
    }

    // get table data
	$result = $db->load_data($table_name);
    $table_data = [];
	if($result){
		while ($row = $result->fetch(PDO::FETCH_BOTH)){
            $item = [];
			foreach($table_info["columns"] as $col){
                $title = $col["column_name"];
                $item[$title] = $row[$title];
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