<?php

	$menu_array = array();
	$menu_array[] = array('id' => 'rest_api_builder', 'parent' => '', 'name' => 'Rest API Builder', 'link' => 'rest_api_builder');
	$menu_array[] = array('id' => 'table_builder', 'parent' => '', 'name' => 'Table Builder', 'link' => 'table_builder');
	$menu_array[] = array('id' => 'form_builder', 'parent' => '', 'name' => 'Form Builder', 'link' => 'form_builder');
	echo json_encode($menu_array);
?>