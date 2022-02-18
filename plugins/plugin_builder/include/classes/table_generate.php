<?php
include_once '../../../../config/config.php';
include_once '../../../../config/database.php';
include_once './table_gen.php';

$db = new Database();
$db->getConnection(API_DB_NAME );

extract($_POST );
switch($type ){
    case "sql":
        generate_sql($json_data );
        break;
    case "html":
        generate_html($json_data );
        break;
    case "javascript":
        generate_javascript($json_data );
        break;
    case "php":
        generate_php($json_data );
        break;
    case "json":
        generate_json($json_data );
        break;
    case "run":
        generate_run($json_data );
        break;
    case "save":
        generate_save($json_data );
        break;
    case "table_list":
        get_table_list();
        break;
    case "table_info":
        get_table_info($table );
        break;
}

function get_table_info($table){
    $db = $GLOBALS["db"];
    $table_info = $db->table_info($table );
    echo  json_encode($table_info );
}

function get_table_list(){
    $dirs = scandir($_SERVER["DOCUMENT_ROOT"] . "/plugins/plugin_product_catalog/interfaces/admin");

    $tables = [];
    foreach($dirs as $item ){
        if ($item != "." && $item != ".." && strpos($item, ".php") > 0 ){
            $substr = substr($item, 0, strlen($item) - 4 );
            array_push($tables, $substr );
        }
    }
    echo json_encode($tables );
}

function generate_sql($data ){
    $sql = generate_content($data, "sql");
    echo json_encode($sql );
}

function generate_html($data ){
    $sql = generate_content($data, "html");
    echo json_encode($sql );
}

function generate_javascript($data ){
    $sql = generate_content($data, "javascript");
    echo json_encode($sql );
}

function generate_php($data ){
    $sql = generate_content($data, "php");
    echo json_encode($sql );
}

function generate_json($data ){
    $json = generate_content($data, "json");
    echo json_encode($json );
}

function generate_run($data ){
    $run = generate_content($data, "run");
    echo json_encode($run );
}

function generate_save($data ){
    $run = generate_content($data, "save");
    echo json_encode($json );
}