<?php
	$json_path = "menu.json";
	$menu_array = json_decode(file_get_contents($json_path));
	echo json_encode($menu_array);
?>