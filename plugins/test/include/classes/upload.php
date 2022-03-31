<?php
    $uploaddir = $_SERVER["DOCUMENT_ROOT"] . "/plugins/uploads/";
    $uploadfile = $uploaddir . basename($_FILES['apifile']['name']);

    $result = ["status"=> "success", "file"=> ""];
    if (move_uploaded_file($_FILES['apifile']['tmp_name'], $uploadfile)) {
        $result["file"] = basename($_FILES['apifile']['name']);
    } else {
        $result["status"] = "fail";
    }
    echo json_encode($result );
?>