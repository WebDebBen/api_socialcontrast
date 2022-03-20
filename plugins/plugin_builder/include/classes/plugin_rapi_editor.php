<?php

extract($_POST);
switch($type ){
    case "rapi_list":
        script_list($plugin_name);
        break;
    case "load_rapi_content":
        load_rapi_content($plugin_name, $api_name );
        break;
    case "load_rapi_doc":
        load_rapi_doc($plugin_name, $api_name );
        break;
    case "save_rapi_content":
        save_rapi_content($plugin_name, $api_name, $content);
        break;
}

function script_list($plugin_name){
    $dirs = scandir($_SERVER["DOCUMENT_ROOT"] . "/plugins/" . $plugin_name . "/api/calls");
    $scripts = [];
    foreach($dirs as $item ){
        if ($item != "." && $item != ".." ){
            array_push($scripts, $item );
        }
    }
    echo json_encode(["status"=> "success", "data"=> $scripts]);
}

function save_rapi_content($plugin_name, $api_name, $content){
    $path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/{$plugin_name}/api/calls/{$api_name}/{$api_name}.php";
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

function load_rapi_content($plugin_name, $api_name ){
    $path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/{$plugin_name}/api/calls/{$api_name}/{$api_name}.php";
    $result = ["status"=> "success", "data"=> ""];
    if (file_exists($path )){
        $result["content"] = file_get_contents($path);
    }else{
        $result["status"] = "error";
    }
    echo json_encode($result);
}

?>