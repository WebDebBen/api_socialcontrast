<?php
include_once '../../../../config/config.php';
include_once '../../../../config/database.php';

$db = new Database();
$db->getConnection(API_DB_NAME );

extract($_POST );
switch($type ){
    case "load_plugin_menu":
        load_plugin_menu($plugin_name);
        break;
    case "save_plugin_menu":
        save_plugin_menu($plugin_name, $data_id, $menu_id, $menu_parent, $menu_name, $menu_link);
        break;
    case "delete_plugin_menu":
        delete_plugin_menu($plugin_name, $data_id );
        break;
}

function load_plugin_menu($plugin_name){
    $menu_path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/{$plugin_name}/settings/menu.json";
    $menu_data = "[]";
    if (file_exists($menu_path)){
        $menu_data = file_get_contents($menu_path);
    }
    echo $menu_data;
}

function save_plugin_menu($plugin_name, $data_id, $menu_id, $menu_parent, $menu_name, $menu_link){
    $menu_path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/{$plugin_name}/settings/menu.json";
    $menu_data = "[]";
    if (file_exists($menu_path)){
        $menu_data = json_decode(file_get_contents($menu_path));
    }
    $new_data = [];
    if ($data_id == "-1"){
        array_push($menu_data, ["id"=> $menu_id, "parent"=> $menu_parent, "name"=> $menu_name, "link"=> $menu_link]);
        $new_data = $menu_data;
    }else{
        foreach($menu_data as $item){
            if($item->id == $data_id ){
                array_push($new_data, ["id"=> $menu_id, "parent"=> $menu_parent, "name"=> $menu_name, "link"=> $menu_link]);
            }else{
                array_push($new_data, $item);
            }
        }
    }
    $myfile = fopen($menu_path, "w") or die("Unable to open file!");
    fwrite($myfile, json_encode($new_data));
    fclose($myfile);

    echo json_encode($new_data);
}

function delete_plugin_menu($plugin_name, $data_id ){
    $menu_path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/{$plugin_name}/settings/menu.json";
    $menu_data = "[]";
    if (file_exists($menu_path)){
        $menu_data = json_decode(file_get_contents($menu_path));
    }

    $new_data = [];
    foreach($menu_data as $item){
        if($item->id != $data_id ){
            array_push($new_data, $item);
        }
    }

    $myfile = fopen($menu_path, "w") or die("Unable to open file!");
    fwrite($myfile, json_encode($new_data));
    fclose($myfile);
    echo json_encode($new_data);
}

?>