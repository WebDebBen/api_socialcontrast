<?php
    class System1{

        // Connection
        private $conn;
        

        // Columns
        public $id;
        public $records_per_page;
        public $page;
        public $search_fields;
        public $response;

        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }

        // GET ALL
        
        public function getAdminMenu(){
          
            $this->records_per_page = htmlspecialchars(strip_tags(trim($this->records_per_page)));
            $this->page = htmlspecialchars(strip_tags(trim($this->page)));
            
            if($this->records_per_page == ''){
            	$this->records_per_page = 20;
            }
            if($this->page == ''){
            	$this->page = 1;
            }
            
            $filters_array = array();
            $bind_parameters_array = array();
            
            $filters = '';
            if(count($filters_array) > 0){
            	 $filters = ' WHERE ' . implode(' AND ', $filters_array);
            }

    		$Arr = array();
        	$Arr["records"] = array();
        	
        	$sqlQuery = "SELECT 
								t1.*,
								t2.id as parent_id,
								sp.plugin_type
							FROM system_menu t1 
							LEFT JOIN system_menu t2 ON t1.parent_id = t2.id AND t2.visible = 1 
							left join system_plugins sp on t1.plugin_name_fk=sp.plugin_name
							GROUP BY t1.id 
							ORDER BY t1.id ASC";
			$stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute(); 
        	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        		extract($row);
				$sub_link = $plugin_type == "plugin" ? 
					ROOT_URL . '/admin/plugins/'.$row['plugin_name_fk'].'/' : 
					ROOT_URL . '/admin/system/'.$row['plugin_name_fk'].'/';
        		$e = array(
                			"parent" => $parent_id,
                			"namecode" => $id,
                			"name" => $display_name,
                			"link" => $sub_link . $link );

            	array_push($Arr["records"], $e);

            	//$json_url = './plugins/' . $row['plugin_name_fk'] . '/settings/menu.php';
				$json_url = $plugin_type == "plugin" ?
					'./plugins/' . $row['plugin_name_fk'] . '/settings/menu.php':
					'./cloudcms/system/plugins/' . $row['plugin_name_fk'] . '/settings/menu.php';

        		if($row['plugin_name_fk'] != '' && file_exists($json_url)){
        			$json_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]" .$json_url;
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_URL, $json_url);
					$result = curl_exec($ch);
					curl_close($ch);

					$obj = json_decode($result);

					foreach($obj as $keyarray){
						$parent_id = $keyarray->parent;
						if($parent_id == ''){
							$parent_id = $id;
						}
						$e = array(
								"parent" => $parent_id,
								"namecode" => $keyarray->id,
								"name" => $keyarray->name,
								//"link" => ROOT_URL . '/admin/plugins/'.$row['plugin_name_fk'].'/'.$keyarray->link 
								"link" => $sub_link . $keyarray->link 
								);
						array_push($Arr["records"], $e);
					}
        		}
        	}
        	return json_encode($Arr["records"]);
        }
		public function getPlugins(){
    		$Arr = array();
        	$Arr["records"] = array();
        	
        	$sqlQuery = "SELECT 
								t1.*     
							FROM system_plugins t1";
			$stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
        	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        		extract($row);

            	array_push($Arr["records"], $row);
        	}	
        	return json_encode($Arr["records"]);
        }
        public function getPluginInterfaces(){
          
            $this->plugin_name = trim($this->plugin_name);
            $interfaces = (object)array();
            
            $json_url = './plugins/' .  $this->plugin_name . '/settings/interfaces.php';
			if(file_exists($json_url)){
				$json_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]" .$json_url;
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_URL, $json_url);
				$result = curl_exec($ch);
				curl_close($ch);

				$interfaces = $result;
			}
				
        	return $interfaces;
        	
        }
       
    }
    
?>