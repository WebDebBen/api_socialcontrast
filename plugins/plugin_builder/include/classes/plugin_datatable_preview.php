<?php
include_once '../../../../config/config.php';
include_once '../../../../config/database.php';

$db = new Database();
$db->getConnection(API_DB_NAME );

extract($_POST );
switch($type ){
    case "datatable_list":
        load_datatable_list($plugin_name);
        break;
    case "datatable_info":
        load_datatable_item($plugin_name, $table_name);
        break;
    case "load_datatable_data":
        load_datatable_data($table_name);
        break;
    case "load_data":
        load_dtp_table_data($id, $table_name);
        break;
}

function load_dtp_table_data($id, $table_name){
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

function load_datatable_data($table_name){
    $db = $GLOBALS["db"];
    $result = $db->load_records_object("select * from {$table_name}");
    echo json_encode($result);
}

function load_datatable_list($plugin_name){
    $dirs = scandir($_SERVER["DOCUMENT_ROOT"] . "/plugins/{$plugin_name}/settings/tables/");
    $datatables = [];
    foreach($dirs as $item ){
        if ($item != "." && $item != ".." && $item != ".json"){
            array_push($datatables, $item );
        }
    }
    echo json_encode(["status"=>"success", "list"=>$datatables]);
}

function load_datatable_item($plugin_name, $datatable_name){
    $path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/{$plugin_name}/settings/tables/{$datatable_name}";
    $json_data = file_get_contents($path);
    echo $json_data;
}

?>