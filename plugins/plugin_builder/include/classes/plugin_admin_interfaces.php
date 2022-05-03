<?php
include_once '../../../../config/config.php';
include_once '../../../../config/database.php';

$db = new Database();
$db->getConnection(API_DB_NAME );

extract($_POST );
switch($type ){
    case "get_folder_structure":
        load_folder_structure($plugin_name);
        break;
    case "get_folder_list":
        load_folder_list($plugin_name, $parent);
        break;
    case "get_file_content":
        load_file_content($plugin_name, $path);
        break;
}

function load_file_content($plugin_name, $path){
    $root_path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/{$plugin_name}/";
    $path = $root_path . $path;
    $result = ["status"=> "success", "content"=> ""];
    if (!file_exists($path )){
        $result["status"] = "file not exist";
    }else{
        $result["content"] = file_get_contents($path);
    }
    echo json_encode($result); 
}

function load_folder_list($plugin_name, $parent){
    $root_path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/{$plugin_name}/";
    $path = $root_path . $parent;
    $infos = scandir($path);
    $folder_data = [];
    $file_data = [];
    foreach($infos as $item){
        if ($item != "." && $item != ".."){
            if (is_dir($path . "/" . $item) == true ){
                $folder_data[] = $item;
            }else{
                $file_data[] = $item;
            }
        }
    }
    echo json_encode(["folders"=> $folder_data, "files"=> $file_data]);
}

function listFolderFiles($dir)
{
    $fileInfo = scandir($dir);
    $allLists = [];
    $tmp1 = [];
    foreach($fileInfo as $level1_folder ){
        if ($level1_folder !== '.' && $level1_folder !== '..' && is_dir($dir . "/" . $level1_folder) === true) {
            $tmp1_item = ["id"=>$level1_folder , "text"=> $level1_folder, "children"=> []];
            $level2_folders = scandir($dir . "/" . $level1_folder);
            $tmp2 = [];
            foreach($level2_folders as $level2){
                if ($level2 !== '.' && $level2 !== '..' && is_dir($dir . "/" . $level1_folder . "/" . $level2) === true) {
                    $tmp2_item = ["id"=>$level1_folder ."/" . $level2, "text"=> $level2, "children"=> []];
                    $level3_folders = scandir($dir . "/" . $level1_folder . "/" . $level2);
                    $tmp3 = [];
                    foreach($level3_folders as $level3){
                        if ($level3 !== '.' && $level3 !== '..' && is_dir($dir . "/" . $level1_folder . "/" . $level2 . "/" . $level3) === true) {
                            $tmp3_item = ["id"=>$level1_folder . "/" . $level2 . "/" . $level3, "text"=>$level3, "children"=> []];
                            $level4_folders = scandir($dir . "/" . $level1_folder . "/" . $level2 . "/" . $level3);
                            $tmp4 = [];
                            foreach($level4_folders as $level4){
                                if ($level4 !== '.' && $level4 !== '..' && is_dir($dir . "/" . $level1_folder . "/" . $level2 . "/" . $level3 . "/" . $level4) === true) {
                                    $tmp4[] = ["id"=> $level1_folder . "/" . $level2 . "/" . $level3 . "/" . $level4, "text"=> $level4, "children"=>false];
                                }
                            }
                            if (count($tmp4) < 1){
                                $tmp3_item["children"] = false;
                            }else{
                                $tmp3_item["children"] = $tmp4;
                            }
                            $tmp3[] = $tmp3_item;
                        }
                    }
                    if (count($tmp3) < 1){
                        $tmp2_item["children"] = false;
                    }else{
                        $tmp2_item["children"] = $tmp3;
                    }
                    $tmp2[] = $tmp2_item;
                }
            }
            if (count($tmp2) < 1){
                $tmp1_item["children"] = false;
            }else{
                $tmp1_item["children"] = $tmp2;
            }
            $tmp1[] = $tmp1_item;
        }
    }
    $allLists = $tmp1;
    return $allLists;
}

function load_folder_structure($plugin_name){
    $root_path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/{$plugin_name}/";
    $file_structure = listFolderFiles($root_path);
    echo json_encode($file_structure);
}


?>