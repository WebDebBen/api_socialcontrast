<?php
include_once '../../../../config/config.php';
include_once '../../../../config/database.php';

$db = new Database();
$db->getConnection(API_DB_NAME );

extract($_POST );
switch($type ){
    case "load_interface_data":
        load_interface_data($plugin_name, $interface_name);
        break;
    case "save_interface_data":
        save_interface_data($plugin_name, $interface_name, $content );
        break;
    case "load_new_interfaces":
        load_new_interfaces($plugin_name);
        break;
    case "new_interface_data":
        new_interface_name($plugin_name, $interface_name, $content);
        break;
    case "delete_interface_data":
        delete_interface_data($plugin_name, $interface_name);
        break;
}

function delete_interface_data($plugin_name, $interface_name ){
    $path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/" . $plugin_name . "/interfaces/admin/{$interface_name}";
    unlink($path );
    echo json_encode(["status"=> "success"]);
}

function load_new_interfaces($plugin_name){
    $dirs = scandir($_SERVER["DOCUMENT_ROOT"] . "/plugins/" . $plugin_name . "/interfaces/admin");
    $origin_names = ["form_builder.php", "plugin_editor.php", "plugins.php", "rest_api_builder.php", "table_builder.php"];
    $interfaces = [];
    foreach($dirs as $item ){
        if ($item != "." && $item != ".." && strpos($item, ".php") > 0 && in_array($item, $origin_names) == false){
            array_push($interfaces, ["interface_name"=> $item, "file_name"=> $item] );
        }
    }
    echo json_encode(["status"=> "success", "data"=> $interfaces]);
}

function new_interface_name($plugin_name, $interface_name, $content){
    $interface_path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/{$plugin_name}/interfaces/admin/{$interface_name}.php";
    if (file_exists($interface_path)){
        echo json_encode(["status"=> "exist"]);
    }else{
        $myfile = fopen($interface_path, "w") or die("Unable to open file!");
        fwrite($myfile, $content);
        fclose($myfile);
        echo json_encode(["status"=> "success"]);
    }
}

function load_interface_data($plugin_name, $interface_name){
    $interface_path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/{$plugin_name}/interfaces/admin/{$interface_name}.php";
    $interface_data = "";
    if (file_exists($interface_path)){
        $interface_data = file_get_contents($interface_path);
    }
    echo json_encode(["status"=> "success", "data"=> $interface_data]);
}

function save_interface_data($plugin_name, $interface_name, $content){
    $interface_path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/{$plugin_name}/interfaces/admin/{$interface_name}.php";
    $myfile = fopen($interface_path, "w") or die("Unable to open file!");
    fwrite($myfile, $content);
    fclose($myfile);
    echo json_encode(["status"=> "success"]);
}