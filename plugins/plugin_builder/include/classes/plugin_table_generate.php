<?php
include_once '../../../../config/config.php';
include_once '../../../../config/database.php';
include_once './plugin_table_gen.php';

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
        generate_save($json_data, $plugin_name );
        break;
    case "table_list":
        get_table_list();
        break;
    case "table_info":
        get_table_info($table );
        break;
    case "table_data":
        get_table_data($obj_id, $ref_table, $ref_field );
        break;
}

function get_table_data($obj_id, $ref_table, $ref_field ){
    $db = $GLOBALS["db"];
    $table_data = $db->load_data($ref_table );
    $rs = [];
    while($row = $table_data->fetch(PDO::FETCH_ASSOC)){
        array_push($rs, $row );
    }

    $table_info = $db->table_info($ref_table );

    echo json_encode(["status"=>"success", "rs"=> $rs, "table_info"=> $table_info ]);
}

function get_table_info($table){
    $db = $GLOBALS["db"];
    $table_info = $db->table_info($table );
    echo  json_encode($table_info );
}

function get_table_list(){
    $db = $GLOBALS["db"];
    $table_list = $db->show_tables();

    $dirs = scandir($_SERVER["DOCUMENT_ROOT"] . "/plugins/plugin_product_catalog/interfaces/admin");
    $tables = [];
    foreach($dirs as $item ){
        if ($item != "." && $item != ".." && strpos($item, ".php") > 0 ){
            $substr = substr($item, 0, strlen($item) - 4 );
            array_push($tables, $substr );
        }
    }
    echo json_encode(["all"=>$table_list, "made"=>$tables]);
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

function generate_save($data, $plugin_name ){ 
    $run = generate_content($data, "save", $plugin_name);
    echo json_encode($run );
}