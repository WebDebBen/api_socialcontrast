<?php
include_once '../../../../config/config.php';
include_once '../../../../config/database.php';

$db = new Database();
$db->getConnection(API_DB_NAME );

extract($_POST );
switch($type ){
    case "load_query_list":
        load_query_list($plugin_name);
        break;
    case "run_query":
        run_table_query($query );
        break;
    case "save_query":
        save_table_query($query_name, $query, $plugin_name);
        break;
    case "load_query":
        load_query($plugin_name, $query_name );
        break;
}

function load_query($plugin_name, $query_name){
    $sql_path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/{$plugin_name}/interfaces/query/{$query_name}";
    $query_data = file_get_contents($sql_path);
    echo json_encode(["status"=> 'sucess', "data"=> $query_data]);
}

function load_query_list($plugin_name){
    $dirs = scandir($_SERVER["DOCUMENT_ROOT"] . "/plugins/" . $plugin_name . "/interfaces/query/");
    $scripts = [];
    foreach($dirs as $item ){
        if ($item != "." && $item != ".." ){
            array_push($scripts, $item );
        }
    }
    echo json_encode($scripts);
}

function save_table_query($query_name, $query, $plugin_name ){
    $db = $GLOBALS["db"];
    $sql_path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/{$plugin_name}/interfaces/query/{$query_name}.sql";
    $result = $db->run_query_with_error($query);
    if ($result["status"] == "error"){
        echo json_encode(["status"=> "error", "result"=> $result["result"]]);
        return;
    }   
    if (file_exists($sql_path )){
        unlink($sql_path );
    }
    $myfile = fopen($sql_path, "w") or die("Unable to open file!");
    fwrite($myfile, $query );
    fclose($myfile);
    echo json_encode(["status"=> "success"]);
}

function run_table_query($query ){
    $db = $GLOBALS["db"];
    $result = $db->run_query_with_error($query);
    echo json_encode($result);
}
?>