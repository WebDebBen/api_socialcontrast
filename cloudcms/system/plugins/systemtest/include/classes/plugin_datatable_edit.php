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
    case "table_view_list":
        load_table_view_list($plugin_name );
        break;
    case "table_view_columns":
        load_table_view_columns($table_name);
        break;
    case "datatable_columns":
        load_datatable_columns($table_name, $plugin_name);
        break;
    case "save_datatable_data":
        save_datatable_data($datatable_name, $table_name, $json_data, $plugin_name);
        break;
}

function load_datatable_columns($table_name, $plugin_name){
    $path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/{$plugin_name}/settings/tables/{$table_name}";
    $result = ["status"=> "success", "content"=> ""];
    if (file_exists($path )){
        $result["content"] = file_get_contents($path);
    }else{
        $result["status"] = "error";
    }
    echo json_encode($result);
}

function save_datatable_data($datatable_name, $table_name, $json_data, $plugin_name){
    $data = ["datatable_name"=> $datatable_name, "table_name"=> $table_name, "columns"=> $json_data["columns"]];
    $path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/{$plugin_name}/settings/tables/{$datatable_name}.json";
    $result = ["status"=> "success"];

    $myfile = fopen($path, "w") or die("Unable to open file!");
    fwrite($myfile, json_encode($data));
    fclose($myfile);
    echo json_encode($result); 
}

function load_table_view_columns($table_name){
    $db = $GLOBALS["db"];
    $table_info = $db->table_info($table_name);
    echo json_encode($table_info);
}

function load_datatable_list($plugin_name){
    $dirs = scandir($_SERVER["DOCUMENT_ROOT"] . "/plugins/{$plugin_name}/settings/tables/");
    $datatables = [];
    foreach($dirs as $item ){
        if ($item != "." && $item != ".." ){
            array_push($datatables, $item );
        }
    }
    echo json_encode($datatables);
}

function load_table_view_list($plugin_name){
    $db = $GLOBALS["db"];
    $query = "show full tables";
    $result = $db->load_records_data($query);
    echo json_encode($result);
}

?>