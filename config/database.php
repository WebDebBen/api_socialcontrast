<?php
    
    class Database {
        private $host = DB_HOST;
        private $database_name = DB_NAME;
        private $username = DB_USER;
        private $password = DB_PASSWORD;

        public $conn;

        public function getConnection($db_name = "" ){
            if ($db_name == "" ){
               $db_name = $this->database_name;
            }
            $this->conn = null; 
            $con = new PDO("mysql:host=" . $this->host . ";dbname=" . $db_name, $this->username, $this->password);
 
            if (mysqli_connect_errno()) {
                printf("Connect failed: %s\n", mysqli_connect_error());
                exit();
            } else {
                $this->conn = $con;
            }

            return $this->conn;
        }

        function show_tables(){
            $query = "show tables"; 
            $sth = $this->conn->prepare($query );
            $sth->execute();
            $tables = [];
            while ($row = $sth->fetch(PDO::FETCH_NUM)){
                array_push($tables, $row[0] );
            }
            return $tables;
        }

        function record_count($query ){
            $result = $this->conn->query($query );
            if ($result ){
                $count = 0;
                while($row = $result->fetch(PDO::FETCH_BOTH)){
                    $count++;
                }
                return $count;
            }
            return 0;
        }

        function run_query($query ){
            $stmt = $this->conn->query($query );
            return $this->conn->lastInsertId();//mysqli_insert_id($this->conn );
        }

        function run_query_result($query){
            $result = $this->conn->query($query );
            if ($result){
                return true;
            }else{
                return $this->conn->errorInfo();
            }
        }

        function run_query_with_error($query){
            $result = $this->conn->query($query );
            if($result) {
                $table_data = [];
                while($row = $result->fetch(PDO::FETCH_ASSOC)){
                    $item = [];
                    foreach($row as $key=>$value){
                        array_push($item, ["key"=> $key, "value"=> $value]);
                    }
                    array_push($table_data, $item);
                }
                return ["status"=> "success", "result"=> $table_data];
            } else {
                return ["status"=> "error", "result"=> $this->conn->errorInfo()];
            }
        }

        function load_records($query){
            $result = $this->conn->query($query );
            return $result;
        }

        function load_records_data($query){
            $result = $this->conn->query($query );
            $data = [];
            if($result){
                while ($row = $result->fetch(PDO::FETCH_ASSOC)){
                    $item = [];
                    foreach($row as $key=>$value){
                        array_push($item, ["key"=> $key, "value"=> $value]);
                    }
                    array_push($data, $item );
                }
            }
            return $data;
        }

        public function load_commit_list($plugin_name){
            $query = "show tables where Tables_in_generator = 'commits'";
            $result = $this->conn->query($query );

            if (!$result){
                $query = "CREATE TABLE `commits`  (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `plugin_name` varchar(255) NULL DEFAULT NULL,
                    `name` varchar(255) NULL DEFAULT NULL,
                    `description` varchar(255) NULL DEFAULT NULL,
                    `is_commited` int NULL DEFAULT 1,
                    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`) USING BTREE
                  ) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci";
                $this->conn->query($query);
            }
            $query = "select * from commits where plugin_name='{$plugin_name}'";
            $result = $this->conn->query($query );
            if ($result){
                $plugins = [];
                while($row = $result->fetch(PDO::FETCH_BOTH)){
                    array_push($plugins, ["name"=>$row["name"], "description"=> $row["description"], "is_commited"=> $row["is_commited"]]);
                }
                return $plugins;
            }else{
                return [];
            }
        }

        public function load_plugins(){
            $query = "show tables where Tables_in_generator = 'plugins'";
            $result = $this->conn->query($query );
            if (!$result){
                $query = "CREATE TABLE `plugins`  (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `name` varchar(255) NULL DEFAULT NULL,
                    PRIMARY KEY (`id`) USING BTREE
                  ) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci";
                $this->conn->query($query);
            }
            $query = "select * from plugins";
            $result = $this->conn->query($query );
            if ($result){
                $plugins = [];
                while($row = $result->fetch(PDO::FETCH_BOTH)){
                    array_push($plugins, $row["name"]);
                }
                return $plugins;
            }else{
                return [];
            }
        }

        public function load_data($table ){
            $query = "select * from {$table }";
            $result = $this->conn->query($query );
            return $result;
        }
        
        public function update_query($query ){
            $stmt = $this->conn->query($query );
            return $this->conn->lastInsertId();//mysqli_insert_id($this->conn );
        }

        public function last_insert_id(){
            $this->conn->lastInsertId();
        }

        function table_list(){
            $query = "show tables";
            $result = $this->conn->query($query );
            return $result;
        }

        function table_infos($tables ){
            $infos = [];
            foreach($tables as $item ){
                $info = $this->table_info($item );
                if ($info ){
                    array_push($infos, $info );
                }
            }
            return $infos;
        }

        function table_info($table_name ){
            $query = "SELECT
                        ic.EXTRA, ic.COLUMN_NAME, ic.COLUMN_DEFAULT, ic.IS_NULLABLE, ic.DATA_TYPE, ic.CHARACTER_MAXIMUM_LENGTH,
                        ic.COLUMN_TYPE, ic.COLUMN_KEY, ik.REFERENCED_TABLE_NAME, ik.REFERENCED_COLUMN_NAME
                    FROM INFORMATION_SCHEMA.COLUMNS ic
                    LEFT JOIN INFORMATION_SCHEMA.KEY_COLUMN_USAGE ik on ik.REFERENCED_TABLE_SCHEMA = '" . API_DB_NAME . 
                    "' and ik.TABLE_NAME = ic.TABLE_NAME and ik.COLUMN_NAME=ic.COLUMN_NAME
                    WHERE ic.TABLE_NAME = '" . $table_name . "' ORDER BY ic.ORDINAL_POSITION";

            $result = $this->conn->query($query );
            $info = [];
            if ($result ){
                $info["table_name"] = $table_name;
                $info["columns"] = [];
                while($row = $result->fetch(PDO::FETCH_BOTH)){
                    $item = [];
                    $item["column_name"] = $row["COLUMN_NAME"];
                    $item["column_default"] = $row["COLUMN_DEFAULT"];
                    $item["extra"] = $row["EXTRA"];
                    $item["is_nullable"] = $row["IS_NULLABLE"];
                    $item["data_type"] = $row["DATA_TYPE"];
                    $item["character_maximum_length"] = $row["CHARACTER_MAXIMUM_LENGTH"];
                    $item["column_type"] = $row["COLUMN_TYPE"];
                    $item["column_key"] = $row["COLUMN_KEY"];
                    $item["referenced_table_name"] = $row["REFERENCED_TABLE_NAME"];
                    $item["referenced_column_name"] = $row["REFERENCED_COLUMN_NAME"];
                    $info["columns"][] = $item;
                }
                return $info;
            }else{
                return false;
            }
        }
    }  
?>
