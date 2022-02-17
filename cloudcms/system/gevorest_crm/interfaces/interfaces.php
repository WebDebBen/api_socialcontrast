<?php

	$plugin_interfaces = array();
	$plugin_interfaces[] = array('id' => 'crm_dashboard', 'name' => 'crm_dashboard.php', 'page_name' => 'Dashboard');
	
	echo json_encode($plugin_interfaces);
?>