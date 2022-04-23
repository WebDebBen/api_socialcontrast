<?php
    include_once '../../../../config/config.php';
    include_once '../../../../config/database.php';

    $db = new Database();
    $db->getConnection(API_DB_NAME );
    extract($_POST );
    $data = json_decode($data);
    foreach($data as $item){
        $query = "insert into {$table} set ";
        $flag = true;
        foreach ($item as $key=> $value ){
            $key = trim(strtolower($key));

            if($key != "id" && $key != "updated_at" && $key != "updated_id" && $key != "created_at" && $key != "created_id"){
                if ($flag ){
                    $query .= " {$key}='{$value}'";
                    $flag = false;
                }else{
                    $query .= ", {$key}='{$value}'";
                }
            }
        }

        $result = $db->run_query_result($query);
        if (!$result){
            echo json_encode(["status"=> "error", "result"=> $result]);
            exit;
        }
    }

    echo json_encode(["status"=> "success"]);
?>