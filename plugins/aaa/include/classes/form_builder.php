<?php
	$request_method=$_SERVER["REQUEST_METHOD"];

    include_once '../../../../config/config.php';
	include_once '../../../../config/database.php';

	$db = new Database();
	$db->getConnection(API_DB_NAME );
    extract($_POST );
    switch($type )
	{
        case 'save_data':
            save_form_data($table_name, $json_data, $html_data );
            break;
		case 'table_list':
			get_table_list();
			break;
        case 'form_list':
            get_form_list();
            break;
        case 'table_info':
            get_table_info($table_name );
            break;
        case 'load_table_data':
            get_table_data($value );
            break;
        case 'load_form_data':
            get_form_data($value );
            break;
	}

    function get_table_data($value ){
        get_table_info($value );
    }

    function get_form_data($value ){
        extract($_POST );
        $path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/{$plugin_name}/settings/forms/{$value}/{$value}.json";
        $file = file_get_contents($path, true);
        echo $file;
    }

    function save_form_data($table_name, $json, $html ){
        extract($_POST );
        $table_name = $table_name;
        $dir = $_SERVER["DOCUMENT_ROOT"] . "/plugins/{$plugin_name}/settings/forms/{$table_name}"; 
        if (!file_exists($dir )){
            mkdir($dir, 0700);
        }

        $json_file_name = $table_name . ".json";
        $html_file_name = $table_name . ".html";
        
        $path =  $dir . "/" . $json_file_name;
        if (!file_exists($path )){
            unlink($path );
        }
        $myfile = fopen($path, "w") or die("Unable to open file!");
        fwrite($myfile, $json );
        fclose($myfile);

        $path =  $dir . "/" . $html_file_name;
        if (!file_exists($path )){
            unlink($path );
        }
        $myfile = fopen($path, "w") or die("Unable to open file!");
        fwrite($myfile, $html );
        fclose($myfile);

        $db = $GLOBALS["db"];
        $table_list = $db->table_list();
        $table_names = [];
        while ($row = $table_list->fetch(PDO::FETCH_BOTH)){
            array_push($table_names, $row[0] );
        }

        $form_list = [];
        $dirs = scandir($_SERVER["DOCUMENT_ROOT"] . "/plugins/" . PLUGIN_PATH . "/settings/forms/" );
        foreach($dirs as $item ){
            if ($item != "." && $item != ".." ){
                array_push($form_list, $item );
            }
        }
        
        echo json_encode(["status"=> "success", "table_list"=> $table_names, "form_list"=> $form_list ]);
    }

    function get_table_info($table_name ){ 
        $db = $GLOBALS["db"];
        $table_info = $db->table_info($table_name );
        echo json_encode($table_info );
    }

    function get_table_list(){
        $db = $GLOBALS["db"];
        $table_list = $db->table_list();
        $table_names = [];
        while ($row = $table_list->fetch(PDO::FETCH_BOTH)){
            array_push($table_names, $row[0] );
        }
        
        echo json_encode($table_names );
    }

    function get_form_list(){
        extract($_POST );
        $form_list = [];
        $dirs = scandir($_SERVER["DOCUMENT_ROOT"] . "/plugins/{$plugin_name}/settings/forms/" );
        foreach($dirs as $item ){
            if ($item != "." && $item != ".." ){
                array_push($form_list, $item );
            }
        }
        echo json_encode($form_list );
    }

?>