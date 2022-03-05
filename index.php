<?php
	error_reporting(1); // disable errors
	session_start();
	include_once 'config/config.php';
	include_once 'config/database.php'; 
	define("ROOT_URL", $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["SERVER_NAME"]);

	$database = new Database();
    $db = $database->getConnection();
    

    include_once 'cloudcms/include/classes/all_classes.php';

	if ($_GET["page"] == "api"){
		echo "wonderful";
		exit;
	}

    if(isset($_SESSION["login"]) && $_SESSION['login']['status'] == true){ 
    	$single_admin = new Admin($db);
    	$single_admin->id = $_SESSION['login']['id'];
    	$privileges = json_decode($single_admin->getSingleAdmin());
    }
    if(isset($_POST['action']) && $_POST['action'] == 'check_login'){
    	$item = new Admin($db);
    	$item->username = $_POST['username'];
   		$item->password = $_POST['password'];
   		$response = json_decode($item->getloginAdmin());
    	if($response->status == true){
    		$_SESSION['login']['status'] = $response->status;
    		$_SESSION['login']['id'] = $response->id;
    		$_SESSION['login']['salesman_id'] = $response->salesman_id;
    		echo '<script type="text/javascript">window.location = "index.php";</script>';
    	}
    	else{
    		echo $response->message;
    	}
    }else if(isset($_GET['page']) && $_GET['page'] == 'logout'){
    	session_destroy();
    	$redirect_link = 'http://'.$_SERVER['HTTP_HOST'];
			echo '<script type="text/javascript">window.location = "'.$redirect_link.'";</script>';
    	die;
    }

	$item_plugins = new System1($db);
	$plugins_records = json_decode($item_plugins->getPlugins()); 

	foreach($plugins_records as $plugin){
		$json_url = './plugins/' . $plugin->plugin_name . '/settings/classes.php';
		if(file_exists($json_url)){
			$json_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]" .$json_url;
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_URL, $json_url);
			$result = curl_exec($ch);
			curl_close($ch);

			$plugin_classes = json_decode($result);
        	foreach($plugin_classes as $class_name){
				$classes_url = './plugins/' . $plugin->plugin_name . '/include/classes/' . $class_name;
				if(file_exists($classes_url)){
					include_once($classes_url);
				}
        	}
        }
	}

    if(isset($_SESSION['login']) && $_SESSION['login']['status'] == true){
		$page = $_GET['page'];
		$type = $_GET['type'];
		$module = $_GET['module'];
		$interface_name = $_GET['interface_name'];
		if(isset($_GET['action']) && $_GET['action'] == 'select_user'){
			$customer_visit_upd = new Customer($db);
			$customer_visit_upd->visit_id = $_SESSION['visit_id'];
			$customer_visit_upd->customer_id = $_GET['id'];
			$customer_visit_upd_response = json_decode($customer_visit_upd->UpdateCustomerVisit());
			$_SESSION['customer_id'] = $_GET['id'];
		}

		// if($module == ''){
// 			$module = 'gevorest_pos';
// 		}
// 		if($interface_name == ''){
// 			$interface_name = 'customer_meet';
// 		}
		if ($module == 'plugin_creator'){
			$module = 'plugin_creator/' . $interface_name;
			$interface_name = "edit";
		}

		include 'cloudcms/theme/index.php';
    } 
    else{
    	include 'cloudcms/theme/login.php';
    } 
?>