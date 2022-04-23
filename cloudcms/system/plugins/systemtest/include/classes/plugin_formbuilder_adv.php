<?php
	$request_method=$_SERVER["REQUEST_METHOD"];

    include_once '../../../../config/config.php';
	include_once '../../../../config/database.php';

	$db = new Database();
	$db->getConnection(API_DB_NAME );
    extract($_POST );
    switch($type )
	{
        case 'formbuilder_list':
            get_form_list($plugin_name );
            break;
        case 'form_data':
            get_form_data($plugin_name, $form_name);
            break;
	}

    function get_form_list($plugin_name){
        $form_list = [];
        $dirs = scandir($_SERVER["DOCUMENT_ROOT"] . "/plugins/{$plugin_name}/settings/forms/" );
        foreach($dirs as $item ){
            if ($item != "." && $item != ".."){
                array_push($form_list, $item );
            }
        }
        echo json_encode($form_list );
    }

    function get_form_data($plugin_name, $form_name){
        $path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/{$plugin_name}/settings/forms/{$form_name}/{$form_name}.json";
        $json_data = file_get_contents($path);
        echo $json_data;
    }

?>