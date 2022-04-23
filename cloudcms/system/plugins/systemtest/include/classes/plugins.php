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
        save_plugin($name, $plugin_type );
        break;
    case 'delete_plugin':
        delete_plugin($name, $plugin_type );
        break;
}

function load_plugins(){
    $db = $GLOBALS["db"];
    $plugins = $db->load_plugins();
    echo json_encode(["status"=> "success", "result"=> $plugins]);
}

function save_plugin($name, $plugin_type ){
    $db = $GLOBALS["db"];
    // check duplicated 
    $folder_name = camelCase($name);
    $query = "select * from system_plugins where plugin_name='{$folder_name}' and plugin_type='{$plugin_type}'";
    $count = $db->record_count($query);
    if ($count > 0 ){
        echo json_encode(["status"=> "duplicated"]);
    }else{
        // create database for the plugin
        /*$db_name = camelCase($name);
        $query = "create database {$db_name}";
        $db->run_query($query );*/

        // create new plugin folder
        if ($plugin_type == "system"){
            $root_path = $_SERVER["DOCUMENT_ROOT"] . "/cloudcms/system/plugins/";
        }else{
            $root_path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/";
        }
        

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
            mkdir($folder_path . "/assets/plugins");
        mkdir($folder_path . "/commits");
        mkdir($folder_path . "/include");
            mkdir($folder_path . "/include/classes");
            mkdir($folder_path . "/include/database_scripts");
        mkdir($folder_path . "/interfaces");
            mkdir($folder_path . "/interfaces/admin");
                mkdir($folder_path . "/interfaces/admin/_sub_items");
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

        // create menu files
        // $plugin_builder_setting_path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/plugin_builder/settings/";
        // $interface_path = $plugin_builder_setting_path . "interfaces.php";
        // $menu_path = $plugin_builder_setting_path . "menu.php";
        // $interface_content = file_get_contents($interface_path);
        // $menu_content = file_get_contents($menu_path);

        // $plugin_interface_path = $folder_path . "/settings/interfaces.php";
        // $plugin_menu_path = $folder_path . "/settings/menu.php";
        // $myfile = fopen($plugin_interface_path, "w");
        // fwrite($myfile, $interface_content);
        // fclose($myfile);
        
        /*$endln = "\n";
        $tab1 = "\t";
        $menu_content = "<?php";
            $menu_content .= $endln . $tab1 . "\$menu_array = array();";
            $menu_content .= $endln . $tab1 . "\$menu_array[] = array('id' => 'plugins', 'parent' => '', 'name' => 'Plugins', 'link' => 'plugin_editor');";
            $menu_content .= $endln . $tab1 . "\$menu_array[] = array('id' => 'rest_api_builder', 'parent' => '', 'name' => 'Rest API Builder', 'link' => 'rest_api_builder');";
            $menu_content .= $endln . $tab1 . "\$menu_array[] = array('id' => 'table_builder', 'parent' => '', 'name' => 'Table Builder', 'link' => 'table_builder');";
            $menu_content .= $endln . $tab1 . "\$menu_array[] = array('id' => 'form_builder', 'parent' => '', 'name' => 'Form Builder', 'link' => 'form_builder');";
            $menu_content .= $endln . $tab1 . "echo json_encode(\$menu_array);";
        $menu_content .= "?>";
        $myfile = fopen($plugin_menu_path, "w");
        fwrite($myfile, $menu_content);
        fclose($myfile);*/

        $source_path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/plugin_builder/settings/";
        $dest_path = $folder_path . "/settings/";
        duplicate_content($source_path, $dest_path);

        // put assets files
        $source_path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/plugin_builder/assets/css/";
        $dest_path = $folder_path . "/assets/css/";
        duplicate_content($source_path, $dest_path);

        $source_path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/plugin_builder/assets/js/";
        $dest_path = $folder_path . "/assets/js/";
        duplicate_content($source_path, $dest_path, ".js");

        $source_path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/plugin_builder/assets/plugins/";
        $dest_path = $folder_path . "/assets/plugins/";
        duplicate_content($source_path, $dest_path);

        // put include files
        $source_path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/plugin_builder/include/classes/";
        $dest_path = $folder_path . "/include/classes/";
        duplicate_content($source_path, $dest_path);

        // put interface files
        $source_path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/plugin_builder/interfaces/admin/";
        $dest_path = $folder_path . "/interfaces/admin/";
        duplicate_content($source_path, $dest_path, ".php");

        $source_path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/plugin_builder/interfaces/admin/_sub_items/";
        $dest_path = $folder_path . "/interfaces/admin/_sub_items/";
        duplicate_content($source_path, $dest_path, ".php");

        $query = "insert into system_plugins set plugin_name='{$folder_name}', plugin_type='{$plugin_type}'";
        $db->run_query($query);

        $query = "insert into system_menu set plugin_name_fk='{$folder_name}', display_name='{$name}', link='crm_dashboard', visible=1";
        $db->run_query($query );

        echo json_encode(["status"=> "success"]);
    }
}

function duplicate_content($source_path, $dest_path, $extension = false){
    $dirs = scandir($source_path );
    foreach($dirs as $item ){
        if ($item != "." && $item != ".." && $item != "" && $item != "js" && $item != "css" && is_dir($source_path . "/" . $item) == false ){
            if ($extension == false || ($extension  != false && strpos($item, $extension))){
                $content = file_get_contents($source_path . $item );
                $myfile = fopen($dest_path . $item, "w");
                fwrite($myfile, $content);
                fclose($myfile);
            }
        }
    }
}

function delete_plugin($name, $plugin_type ){
    $db = $GLOBALS["db"];
    /*$query = "delete from plugins where name='{$name}'"; 
    $db->run_query($query );

    $db_name = camelCase($name );
    $query = "drop database {$db_name}";*/
    $query = "delete from system_menu where plugin_name_fk='{$name}'";
    $db->run_query($query );
    $query = "delete from system_plugins where plugin_name='{$name}' and plugin_type='{$plugin_type}'";
    $db->run_query($query );

    if ($plugin_type == "system"){
        $root_path = $_SERVER["DOCUMENT_ROOT"] . "/cloudcms/system/plugins/";
    }else{
        $root_path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/";
    }
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