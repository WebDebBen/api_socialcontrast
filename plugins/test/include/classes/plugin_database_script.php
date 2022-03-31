<?php

include_once '../../../../config/config.php';

extract($_POST);
switch($type ){
    case "script_list":
        script_list($plugin_name);
        break;
    case "load_ds_content":
        load_ds_content($plugin_name, $script_name );
        break;
    case "delete_ds_script":
        delete_ds_script($plugin_name, $script_name);
        break;
    case "save_ds_script":
        save_ds_script($plugin_name, $script_name);
        break;
    case "save_ds_content":
        save_ds_content($plugin_name, $script_name, $content);
        break;
}

function script_list($plugin_name){
    $dirs = scandir($_SERVER["DOCUMENT_ROOT"] . "/plugins/" . $plugin_name . "/temporary");
    $scripts = [];
    foreach($dirs as $item ){
        if ($item != "." && $item != ".." && strpos($item, ".sql") > 0 ){
            $substr = substr($item, 0, strlen($item) - 4 );
            array_push($scripts, $substr );
        }
    }
    echo json_encode(["status"=> "success", "scripts"=> $scripts]);
}

function save_ds_content($plugin_name, $script_name, $content){
    $path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/{$plugin_name}/temporary/{$script_name}.sql";
    $result = ["status"=> "success"];
    if (!file_exists($path )){
        $result["status"] = "file not exist";
    }else{
        $myfile = fopen($path, "w") or die("Unable to open file!");
        fwrite($myfile, $content);
        fclose($myfile);
    }
    echo json_encode($result); 
}

function save_ds_script($plugin_name, $script_name){
    $path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/{$plugin_name}/temporary/{$script_name}.sql";
    $result = ["status"=> "success"];
    if (file_exists($path )){
        $result["status"] = "duplicated";
    }else{
        $myfile = fopen($path, "w") or die("Unable to open file!");
        fwrite($myfile, "");
        fclose($myfile);
    }
    echo json_encode($result);
}

function load_ds_content($plugin_name, $script_name ){
    $path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/{$plugin_name}/temporary/{$script_name}.sql";
    $result = ["status"=> "success", "data"=> ""];
    if (file_exists($path )){
        $result["data"] = file_get_contents($path);
    }else{
        $result["status"] = "error";
    }
    echo json_encode($result);
}

function delete_ds_script($plugin_name, $script_name){
    $path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/{$plugin_name}/temporary/{$script_name}.sql";
    $result = ["status"=> "success"];
    if (file_exists($path )){
        unlink($path);
    }else{
        $result["status"] = "error";
    }
    echo json_encode($result);
}

?>