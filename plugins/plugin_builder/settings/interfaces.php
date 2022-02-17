<?php

	$plugin_interfaces = array();
	$plugin_interfaces[] = array('id' => 'stock_taking_stores', 'name' => 'stock_taking_stores.php', 'page_name' => 'Stock Taking - Stores');
	$plugin_interfaces[] = array('id' => 'stock_taking_scan', 'name' => 'stock_taking_scan.php', 'page_name' => 'Stock Taking - Scan');
	$plugin_interfaces[] = array('id' => 'stock_taking_products', 'name' => 'stock_taking_products.php', 'page_name' => 'Stock Taking - Scanned Products');
	$plugin_interfaces[] = array('id' => 'stock_taking_delete_store', 'name' => 'stock_taking_delete_store.php', 'page_name' => 'Stock Taking - Delete Store');
	echo json_encode($plugin_interfaces);
?>