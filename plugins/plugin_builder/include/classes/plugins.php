<?php
$request_method=$_SERVER["REQUEST_METHOD"];

include_once '../../../../config/config.php';
include_once '../../../../config/database.php';

$db = new Database();
$db->getConnection();
extract($_POST );
switch($type )
{
    case 'load_plugins':
        load_plugins();
        break;
    case 'save_plugin':
        save_plugin($name );
        break;
    case 'delete_plugin':
        delete_plugin($name );
        break;
}

function load_plugins(){
    $db = $GLOBALS["db"];
    $plugins = $db->load_plugins();
    echo json_encode(["status"=> "success", "result"=> $plugins]);
}

function save_plugin($name ){
    $db = $GLOBALS["db"];
    // check duplicated 
    $query = "select * from plugins where name='{$name}'";
    $count = $db->record_count($query);
    if ($count > 0 ){
        echo json_encode(["status"=> "duplicated"]);
    }else{
        $query = "insert into plugins set name='{$name}'";
        $db->run_query($query );

        // create database for the plugin
        /*$db_name = camelCase($name);
        $query = "create database {$db_name}";
        $db->run_query($query );*/
        
        // create new plugin folder
        $root_path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/plugin_creator/";
        $folder_name = camelCase($name);
        $folder_path = $root_path . $folder_name;
        if (file_exists($folder_path )){
            rrmdir($folder_path );
        }
        mkdir($folder_path );

        mkdir($folder_path . "/api");
            mkdir($folder_path . "/api/calls");
            mkdir($folder_path . "/api/documentation");
        mkdir($folder_path . "/assets");
            mkdir($folder_path . "/assets/css");
            mkdir($folder_path . "/assets/js");
        mkdir($folder_path . "/commits");
        mkdir($folder_path . "/include");
            mkdir($folder_path . "/include/classes");
            mkdir($folder_path . "/include/database_scripts");
        mkdir($folder_path . "/interfaces");
            mkdir($folder_path . "/interfaces/admin");
            mkdir($folder_path . "/interfaces/ajax");
            mkdir($folder_path . "/interfaces/php");
            mkdir($folder_path . "/interfaces/query");
        mkdir($folder_path . "/settings");
            mkdir($folder_path . "/settings/forms");
            mkdir($folder_path . "/settings/tables");
            $myfile = fopen($folder_path . "/settings/settings.json", "w") or die("Unable to open file!");
            fwrite($myfile, "{}");
            fclose($myfile);
        mkdir($folder_path . "/temporary");

        echo json_encode(["status"=> "success"]);
    }
}

function delete_plugin($name ){
    $db = $GLOBALS["db"];
    $query = "delete from plugins where name='{$name}'"; 
    $db->run_query($query );

    $db_name = camelCase($name );
    $query = "drop database {$db_name}";

    $root_path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/plugin_creator/";
    $folder_name = camelCase($name);
    $folder_path = $root_path . $folder_name;
    if (file_exists($folder_path )){
        rrmdir($folder_path );
    }
    echo json_encode(["status"=> "success"]);
}

function rrmdir($dir) { 
    if (is_dir($dir)) { 
      $objects = scandir($dir); 
      foreach ($objects as $object) { 
        if ($object != "." && $object != "..") { 
          if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object); 
        } 
      } 
      reset($objects); 
      rmdir($dir); 
    } 
  } 

function camelCase($str) {
    $i = array("-","_");
    $str = preg_replace('/([a-z])([A-Z])/', "\\1 \\2", $str);
    $str = preg_replace('@[^a-zA-Z0-9\-_ ]+@', '', $str);
    $str = str_replace($i, ' ', $str);
    //$str = str_replace(' ', ' ', ucwords(strtolower($str)));
    $str = str_replace(' ', '_', strtolower($str));
    return $str;
}