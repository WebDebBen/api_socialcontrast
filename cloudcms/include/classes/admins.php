<?php
    class Admin{

        // Connection
        private $conn;

        // Table
        private $db_table = "Admins";
        

        // Columns
        public $id;
        public $username;
        public $password;
        public $pos_enabled;
        public $crm_enabled;
        public $settings_enabled;
        public $salesman_id;
        public $last_login_datetime;
        public $active;
        public $cre_id;
        public $created_date;
        public $last_upd_date;
        public $last_upd_id;
        public $adminstores;
        public $records_per_page;
        public $page;
        public $search_fields;
        public $response;

        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }

        // GET ALL
        public function getloginAdmin(){
        	$this->username = htmlspecialchars(strip_tags(trim($this->username)));
            $this->password = md5(strip_tags(trim($this->password)));
            // $sqlQuery = "SELECT Count(*) as number_of_records, id  FROM " . $this->db_table . " WHERE username = '{$this->username}' AND password = '{$this->password}' AND active = 1";
//             echo $sqlQuery.'<br>';
            $sqlQuery = "SELECT Count(*) as number_of_records, id  FROM " . $this->db_table . " WHERE username = :username AND password = :password AND active = 1";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->bindParam(":username", $this->username);
            $stmt->bindParam(":password", $this->password);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if($row['number_of_records'] == 1){
            	$response->status = 1;
            	$response->id = $row['id'];
            	$response->message = 'Successfull Login';
            }
            else{
            	$response->status = 0;
            	$response->message = 'Check username and password or contact system administrator';
            }
//             die;
            return json_encode($response);
        }
        // GET ALL
        public function getSingleAdmin(){
        	$this->id = htmlspecialchars(strip_tags(trim($this->id)));
        	$this->search_fields->admin_id = $this->id;
            
            $sqlQuery = "SELECT * FROM " . $this->db_table . " WHERE id = :id AND active = 1";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->bindParam(":id", $this->id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if($row['active'] == 1){
            	$store_dependencies = json_decode($this->getAdminStoresDependencies());
            	
            	$response->status = 1;
            	$response->id = $row['id'];
            	$response->pos_enabled = $row['pos_enabled'];
            	$response->stocktaking_enabled = $row['stocktaking_enabled'];
            	$response->settings_enabled = $row['settings_enabled'];
            	$response->crm_enabled = $row['crm_enabled'];
            	$response->salesman_id = $row['salesman_id'];
            	$response->store_dependencies = $store_dependencies->records;
            }
            else{
            	$response->status = 0;
            	$response->message = 'The administrator was not found in the system';
            }
            return json_encode($response);
        }
        public function getAdmin(){
            $this->records_per_page = htmlspecialchars(strip_tags(trim($this->records_per_page)));
            $this->page = htmlspecialchars(strip_tags(trim($this->page)));
            $this->id = htmlspecialchars(strip_tags(trim($this->search_fields->id)));
            $this->username = htmlspecialchars(strip_tags(trim($this->search_fields->username)));
            $this->pos_enabled = htmlspecialchars(strip_tags(trim($this->search_fields->pos_enabled)));
            $this->stocktaking_enabled = htmlspecialchars(strip_tags(trim($this->search_fields->stocktaking_enabled)));
            $this->crm_enabled = htmlspecialchars(strip_tags(trim($this->search_fields->crm_enabled)));
            $this->settings_enabled = htmlspecialchars(strip_tags(trim($this->search_fields->settings_enabled)));
            $this->salesman_id = htmlspecialchars(strip_tags(trim($this->search_fields->salesman_id)));
            $this->active = htmlspecialchars(strip_tags(trim($this->search_fields->active)));
            $this->cre_id = htmlspecialchars(strip_tags(trim($this->search_fields->cre_id)));
            $this->last_upd_id = htmlspecialchars(strip_tags(trim($this->search_fields->last_upd_id)));
            
            if($this->records_per_page == ''){
            	$this->records_per_page = 20;
            }
            if($this->page == ''){
            	$this->page = 1;
            }
            
            $filters_array = array();
            $bind_parameters_array = array();
            if($this->id != ''){
            	$filters_array[] = 'id = :id';
            	$bind_parameters_array[':id'] = $this->id;
            }
            if($this->username != ''){
            	$filters_array[] = 'username LIKE :username';
            	$bind_parameters_array[':username'] = '%'.$this->username.'%';
            }
            if($this->pos_enabled != ''){
            	$filters_array[] = 'pos_enabled = :pos_enabled';
            	$bind_parameters_array[':pos_enabled'] = $this->pos_enabled;
            }
            if($this->stocktaking_enabled != ''){
            	$filters_array[] = 'stocktaking_enabled = :stocktaking_enabled';
            	$bind_parameters_array[':stocktaking_enabled'] = $this->stocktaking_enabled;
            }
            if($this->crm_enabled != ''){
            	$filters_array[] = 'crm_enabled = :crm_enabled';
            	$bind_parameters_array[':crm_enabled'] = $this->crm_enabled;
            }
            if($this->settings_enabled != ''){
            	$filters_array[] = 'settings_enabled = :settings_enabled';
            	$bind_parameters_array[':settings_enabled'] = $this->settings_enabled;
            }
            if($this->salesman_id != ''){
            	$filters_array[] = 'salesman_id = :salesman_id';
            	$bind_parameters_array[':salesman_id'] = $this->salesman_id;
            }
            if($this->active != ''){
            	$filters_array[] = 'active = :active';
            	$bind_parameters_array[':active'] = $this->active;
            }
            if($this->cre_id != ''){
            	$filters_array[] = 'cre_id = :cre_id';
            	$bind_parameters_array[':cre_id'] = $this->cre_id;
            }
            if($this->last_upd_id != ''){
            	$filters_array[] = 'last_upd_id = :last_upd_id';
            	$bind_parameters_array[':last_upd_id'] = $this->last_upd_id;
            }
            $filters = '';
            if(count($filters_array) > 0){
            	 $filters = ' WHERE ' . implode(' AND ', $filters_array);
            }
            
            $sqlQuery = "SELECT Count(*) as number_of_records  
            				FROM " . $this->db_table . 
            				$filters;
            $stmt = $this->conn->prepare($sqlQuery);
            foreach($bind_parameters_array as $key => $value){
            	$stmt->bindParam($key, $value);
            }
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $itemCount = $row['number_of_records'];
            $pageCount = ceil($row['number_of_records'] / $this->records_per_page);
            
            $rowstart = ($this->page - 1) * $this->records_per_page;
            
            $sqlQuery = "SELECT *   
            				FROM " . $this->db_table . 
            				$filters . 
            				" LIMIT " . $rowstart . "," . $this->records_per_page;
            $stmt = $this->conn->prepare($sqlQuery);
            foreach($bind_parameters_array as $key => $value){
            	$stmt->bindParam($key, $value);
            }
            $stmt->execute();
            

    		$Arr = array();
        	$Arr["records"] = array();
        	$Arr["itemCount"] = $itemCount;
        	$Arr["pageCount"] = $pageCount;
        	
        	$sqlStoresQuery = "SELECT Count(*)  as number_of_records   
            						FROM AdminStores 
            						WHERE admin_id = :admin_id";

        	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        		$stmt1 = $this->conn->prepare($sqlStoresQuery);
        		$stmt1->bindParam(':admin_id', $row['id']);
        		$stmt1->execute();
        		$row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
        		
        		extract($row);
        		$e = array(
                			"id" => $id,
                			"username" => $username,
                			"pos_enabled" => $pos_enabled,
                			"stocktaking_enabled" => $stocktaking_enabled,
                			"crm_enabled" => $crm_enabled,
                			"settings_enabled" => $settings_enabled,
                			"salesman_id" => $salesman_id,
                			"active" => $active,
                			"stores" => $row1['number_of_records'],
                			"adminstores" => $adminstores
            				);

            	array_push($Arr["records"], $e);
        	}	
        	return json_encode($Arr);
        }

        // CREATE
        public function createAdmin(){
            // sanitize
            $this->username = htmlspecialchars(strip_tags(trim($this->username)));
            $this->password = md5(strip_tags(trim($this->password)));
            $this->pos_enabled = htmlspecialchars(strip_tags(trim($this->pos_enabled)));
            $this->stocktaking_enabled = htmlspecialchars(strip_tags(trim($this->stocktaking_enabled)));
            $this->crm_enabled = htmlspecialchars(strip_tags(trim($this->crm_enabled)));
            $this->settings_enabled = htmlspecialchars(strip_tags(trim($this->settings_enabled)));
            $this->salesman_id = htmlspecialchars(strip_tags(trim($this->salesman_id)));
            $this->active = htmlspecialchars(strip_tags(trim($this->active)));
            $this->cre_id = htmlspecialchars(strip_tags(trim($this->cre_id)));
            $this->last_upd_id = htmlspecialchars(strip_tags(trim($this->last_upd_id)));
            if($this->salesman_id == ''){
           		$this->salesman_id = null;
            }
            if($this->cre_id == ''){
            	$this->cre_id = null;
            }
            if($this->last_upd_id == ''){
            	$this->last_upd_id = null;
            }
            
            $sqlQuery = "SELECT Count(*) as number_of_records FROM " . $this->db_table . " WHERE username = :username";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->bindParam(":username", $this->username);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if($row['number_of_records'] > 0){
            	$response->success = 0;
            	$response->message = 'Record already exists in the database';
            	
            	return $response;
            
            }
            
            $sqlQuery = "INSERT INTO
                        	". $this->db_table ."
                    		SET
                        		username = :username, 
                        		password = :password, 
                        		pos_enabled = :pos_enabled, 
                        		stocktaking_enabled = :stocktaking_enabled, 
                        		crm_enabled = :crm_enabled, 
                        		settings_enabled = :settings_enabled, 
                        		active = :active, 
                        		salesman_id = :salesman_id, 
                        		cre_id = :cre_id, 
                        		last_upd_id = :last_upd_id, 
                        		created_date = NOW(), 
                        		last_upd_date = NOW()";
            $stmt = $this->conn->prepare($sqlQuery);
        
            // bind data
            $stmt->bindParam(":username", $this->username);
            $stmt->bindParam(":password", $this->password);
            $stmt->bindParam(":pos_enabled", $this->pos_enabled);
            $stmt->bindParam(":stocktaking_enabled", $this->stocktaking_enabled);
            $stmt->bindParam(":crm_enabled", $this->crm_enabled);
            $stmt->bindParam(":settings_enabled", $this->settings_enabled);
            $stmt->bindParam(":active", $this->active);
            $stmt->bindParam(":salesman_id", $this->salesman_id);
            $stmt->bindParam(":cre_id", $this->cre_id);
            $stmt->bindParam(":last_upd_id", $this->last_upd_id);
            
            if($stmt->execute()){
            	$response->success = 1;
            	$response->id = $this->conn->lastInsertId();
            }
            else{
            	$response->success = 0;
            	$response->message = $stmt->errorInfo();
            }
            return $response;
        } 

        // UPDATE
        public function updateAdmin(){
            // sanitize
            $this->id = htmlspecialchars(strip_tags(trim($this->id)));
            $this->username = htmlspecialchars(strip_tags(trim($this->username)));
            $this->pos_enabled = htmlspecialchars(strip_tags(trim($this->pos_enabled)));
            $this->stocktaking_enabled = htmlspecialchars(strip_tags(trim($this->stocktaking_enabled)));
            $this->crm_enabled = htmlspecialchars(strip_tags(trim($this->crm_enabled)));
            $this->settings_enabled = htmlspecialchars(strip_tags(trim($this->settings_enabled)));
            $this->salesman_id = htmlspecialchars(strip_tags(trim($this->salesman_id)));
            $this->active = htmlspecialchars(strip_tags(trim($this->active)));
            $this->last_upd_id = htmlspecialchars(strip_tags(trim($this->last_upd_id)));
            if($this->salesman_id == ''){
           		$this->salesman_id = null;
            }
            if($this->last_upd_id == ''){
            	$this->last_upd_id = null;
            }
            $sqlQuery = "SELECT Count(*) as number_of_records FROM " . $this->db_table . " WHERE username = :username AND id <> :id";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->bindParam(":username", $this->username);
            $stmt->bindParam(":id", $this->id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if($row['number_of_records'] > 0){
            	$response->success = 0;
            	$response->message = 'Record already exists in the database';
            	
            	return json_encode($response);
            
            }
            
            $sqlQuery = "UPDATE
                        		". $this->db_table ."
                    		SET
                        		username = :username, 
                        		pos_enabled = :pos_enabled, 
                        		stocktaking_enabled = :stocktaking_enabled, 
                        		crm_enabled = :crm_enabled, 
                        		settings_enabled = :settings_enabled, 
                        		active = :active, 
                        		salesman_id = :salesman_id, 
                        		last_upd_id = :last_upd_id, 
                        		last_upd_date = NOW()
                    		WHERE 
                        		id = :id";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            // bind data
            $stmt->bindParam(":username", $this->username);
            $stmt->bindParam(":pos_enabled", $this->pos_enabled);
            $stmt->bindParam(":stocktaking_enabled", $this->stocktaking_enabled);
            $stmt->bindParam(":crm_enabled", $this->crm_enabled);
            $stmt->bindParam(":settings_enabled", $this->settings_enabled);
            $stmt->bindParam(":active", $this->active);
            $stmt->bindParam(":salesman_id", $this->salesman_id);
            $stmt->bindParam(":last_upd_id", $this->last_upd_id);
            $stmt->bindParam(":id", $this->id);
            
            if($stmt->execute()){
            	$response->success = 1;
            	return json_encode($response);
            }
            else{
            	$response->success = 0;
            	$response->message = $stmt->errorInfo();
            	return json_encode($response);
            }
        }

        // DELETE
        function deleteAdmin(){
            $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->id = htmlspecialchars(strip_tags($this->id));
        
            $stmt->bindParam(1, $this->id);
        
            if($stmt->execute()){
                return true;
            }
            return false;
        }
        
        public function getAdminStoresDependencies(){
            
            $this->store_id = htmlspecialchars(strip_tags(trim($this->search_fields->store_id)));
            $this->admin_id = htmlspecialchars(strip_tags(trim($this->search_fields->admin_id)));
            $this->active = htmlspecialchars(strip_tags(trim($this->search_fields->active)));
            
            $filters_array = array();
            $bind_parameters_array = array();
            if($this->store_id != ''){
            	$filters_array[] = 'store_id = :store_id';
            	$bind_parameters_array[':store_id'] = $this->store_id;
            }
            if($this->admin_id != ''){
            	$filters_array[] = 'admin_id = :admin_id';
            	$bind_parameters_array[':admin_id'] = $this->admin_id;
            }
            if($this->active != ''){
            	$filters_array[] = 'active = :active';
            	$bind_parameters_array[':active'] = $this->active;
            }
            
            $filters = '';
            if(count($filters_array) > 0){
            	 $filters = ' WHERE ' . implode(' AND ', $filters_array);
            }
            
            $sqlQuery = "SELECT * 
							FROM (SELECT 
										t1.id as store_id, 
										t2.admin_id as admin_id, 
										t1.name,
										CASE 
											WHEN t2.admin_id IS NULL THEN 0 
											ELSE 1 
										END as active    
									FROM Stores t1 
									LEFT JOIN AdminStores t2 ON t1.id = t2.store_id 
									GROUP BY t1.id 
									ORDER BY t1.name ASC) t" . 
            				$filters;
            				
            $stmt = $this->conn->prepare($sqlQuery);
            foreach($bind_parameters_array as $key => $value){
            	$stmt->bindParam($key, $value);
            }
            $stmt->execute();
            

    		$Arr = array();
        	$Arr["records"] = array();

        	
        	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        		extract($row);
        		$e = array(
                			"store_id" => $store_id,
                			"admin_id" => $admin_id,
                			"name" => $name,
                			"active" => $active
            				);

            	array_push($Arr["records"], $e);
        	}	
        	return json_encode($Arr);
        }
        function deleteAdminStoresDependencies(){
            $sqlQuery = "DELETE FROM AdminStores WHERE admin_id = ?";
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->id = htmlspecialchars(strip_tags($this->id));
        
            $stmt->bindParam(1, $this->id);
        
            if($stmt->execute()){
                return true;
            }
            return false;
        }
        
        function changePasswordAdmin(){
            // sanitize
            $this->id = htmlspecialchars(strip_tags(trim($this->id)));
            $this->password = md5(strip_tags(trim($this->password)));
            
            $sqlQuery = "UPDATE " . $this->db_table . 
            			" SET password = :password 
            			WHERE id = :id 
            			LIMIT 1";
            $stmt = $this->conn->prepare($sqlQuery);
        
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':password', $this->password);
            
            if($stmt->execute()){
            	$response->success = 1;
            }
            else{
            	$response->success = 0;
            	$response->message = $stmt->errorInfo();
            }
            return $response;
        }
        function createAdminStoresDependencies(){
            // sanitize
            $this->admin_id = htmlspecialchars(strip_tags(trim($this->admin_id)));
            $this->store_id = htmlspecialchars(strip_tags(trim($this->store_id)));
            
            
            $sqlQuery = "INSERT INTO
                        	AdminStores
                    		SET
                        		admin_id = :admin_id, 
                        		store_id = :store_id";
            $stmt = $this->conn->prepare($sqlQuery);
        
            // bind data
            $stmt->bindParam(":admin_id", $this->admin_id);
            $stmt->bindParam(":store_id", $this->store_id);
            
            if($stmt->execute()){
            	$response->success = 1;
            	$response->id = $this->conn->lastInsertId();
            }
            else{
            	$response->success = 0;
            	$response->message = $stmt->errorInfo();
            }
            return $response;
        }
    }
    
?>