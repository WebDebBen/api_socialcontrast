<?php
    include_once '../../../../config/config.php';
    include_once '../../../../config/database.php';

    $db = new Database();
    $db->getConnection(API_DB_NAME );
    extract($_POST );

    $result = $db->load_data($table);
    $table_info = $db->table_info($table );
    $columns = $table_info["columns"];

    $columnHeader = '';
    $cols = [];
    foreach($columns as $item){
        $columnHeader .= "{$item['column_name']} \t";
        array_push($cols, $item['column_name']);
    }

    $setData = '';
    while($row = $result->fetch(PDO::FETCH_BOTH)){
        $rowData = '';
        foreach($cols as $value ){
            $value = '"' . $row[$value] . '"' . "\t";
            $rowData .= $value;
        }
        $setData .= trim($rowData) . "\n";
    }
    
    // header("Content-type: application/octet-stream");  
    // header("Content-Disposition: attachment; filename=" . $table . ".xls");  
    // header("Pragma: no-cache");  
    // header("Expires: 0");

    $excel_path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/excels/" . $table . ".xls"; 
    $myfile = fopen($excel_path, "w") or die("Unable to open file!");
    fwrite($myfile, ucwords($columnHeader) . "\n" . $setData . "\n" );
    fclose($myfile);

    echo json_encode(["status"=> "success", "file"=> $table . ".xls"]);
?>