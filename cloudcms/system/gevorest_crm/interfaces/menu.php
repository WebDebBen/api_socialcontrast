<?php

	$menu_array = array();
	$menu_array[] = array('id' => 'crm_dashboard', 'parent' => '', 'name' => 'Dashboard', 'link' => 'crm_dashboard');
	
	echo json_encode($menu_array);
?>