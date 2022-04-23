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
        save_commit_item($plugin_name, $commit_short_desc, $commit_desc);
        break;
    case "delete_commit":
        delete_commit($plugin_name, $commit_name, $commit_version);
        break;
    case "set_commit":
        set_commit($plugin_name, $commit_name, $commit_version);
        break;
}

function load_commit_list($plugin_name){
    $db = $GLOBALS["db"];
    $result = $db->load_commit_list($plugin_name);
    echo json_encode(["status"=> "success", "result"=> $result]);
}

function save_commit_item($plugin_name, $commit_short_desc, $commit_desc){
    $db = $GLOBALS["db"];
    $commits = $db->load_commit_list($plugin_name);
    extract($commits);

    $query = "insert into commits(plugin_name, name, version, description, short_description) values('{$plugin_name}', '{$now}', '{$version}', '{$commit_desc}', '{$commit_short_desc}')";
    $result = $db->run_query($query);

    $version = $version < 10 ? "0". $version : $version;
    $path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/{$plugin_name}/commits/{$now}.{$version}";
    mkdir($path );

    echo json_encode(["status"=> "success"]);
}

function set_commit($plugin_name, $commit_name, $commit_version){
    $db = $GLOBALS["db"];
    $version = (int)($commit_version);
    $query = "update commits set is_commited=2 where plugin_name='{$plugin_name}' and name='{$commit_name}' and version={$version}";
    $result = $db->run_query($query);

    $version = $version < 10 ? "0" . $version : $version;
    $commit_path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/{$plugin_name}/commits/{$commit_name}.{$version}/";
    $tmp_path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/" . $plugin_name . "/temporary/";
    $dirs = scandir($tmp_path);

    foreach($dirs as $item ){
        if ($item != "." && $item != ".." && strpos($item, ".sql") > 0 ){ 
            rename($tmp_path . $item, $commit_path . $item);
        }
    }

    $zip = new ZipArchive();
    $zip_path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/{$plugin_name}/commits/";
    $zipcreated = "{$commit_name}.{$version}.zip";
    if($zip->open($zip_path . $zipcreated, ZipArchive::CREATE ) === TRUE) {
      
        // Store the path into the variable
        $dir = opendir($commit_path);
           
        while($file = readdir($dir)) {
            if(is_file($commit_path.$file)) {
                $zip -> addFile($commit_path.$file, $file);
            }
        }
        $zip ->close();
    }

    echo json_encode(["status"=> "success", "zipfile"=> $zipcreated]);
}

function delete_commit($plugin_name, $commit_name, $commit_version){
    $db = $GLOBALS["db"];
    $version = (int)($commit_version);
    $query = "delete from commits where plugin_name='{$plugin_name}' and name='{$commit_name}' and version={$version}";
    $result = $db->run_query($query );

    $version = $version < 10 ? "0" . $version : $version;
    $path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/{$plugin_name}/commits/{$commit_name}.{$version}";

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