<?php

	$menu_array = array();
	$menu_array[] = array('id' => 'stock_taking_stores', 'parent' => '', 'name' => 'Stores', 'link' => 'stock_taking_stores');
	
	echo json_encode($menu_array);
?>