<?php

include_once '../../../../config/config.php';
include_once '../../../../config/database.php';

$db = new Database();
$db->getConnection();
extract($_POST );
switch($type ){
    case "commit_list":
        load_commit_list($plugin_name);
        break;
    case "save_commit":
        save_commit_item($plugin_name, $commit_name, $commit_desc);
        break;
    case "delete_commit":
        delete_commit($plugin_name, $commit_name);
        break;
    case "set_commit":
        set_commit($plugin_name, $commit_name);
        break;
}

function load_commit_list($plugin_name){
    $db = $GLOBALS["db"];
    $result = $db->load_commit_list($plugin_name);
    echo json_encode(["status"=> "success", "result"=> $result]);
}

function save_commit_item($plugin_name, $commit_name, $commit_desc){
    $db = $GLOBALS["db"];
    $query = "insert into commits(plugin_name, name, description) values('{$plugin_name}', '{$commit_name}', '{$commit_desc}')";
    $result = $db->run_query($query);

    $path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/{$plugin_name}/commits/{$commit_name}";
    mkdir($path );

    echo json_encode(["status"=> "success"]);
}

function set_commit($plugin_name, $commit_name){
    $db = $GLOBALS["db"];
    $query = "update commits set is_commited=2 where plugin_name='{$plugin_name}' and name='{$commit_name}'";
    $result = $db->run_query($query);

    $commit_path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/{$plugin_name}/commits/{$commit_name}/";
    $tmp_path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/" . $plugin_name . "/temporary/";
    $dirs = scandir($tmp_path);

    foreach($dirs as $item ){
        if ($item != "." && $item != ".." && strpos($item, ".sql") > 0 ){ 
            rename($tmp_path . $item, $commit_path . $item);
        }
    }
    echo json_encode(["status"=> "success"]);
}

function delete_commit($plugin_name, $commit_name){
    $db = $GLOBALS["db"];
    $query = "delete from commits where plugin_name='{$plugin_name}' and name='{$commit_name}'";
    $result = $db->run_query($query );

    $path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/{$plugin_name}/commits/{$commit_name}";
    if (file_exists($path )){
        rrmdir($path );
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

?>