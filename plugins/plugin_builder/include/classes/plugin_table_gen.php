<?php

    function camelCase($str) {
        $i = array("-","_");
        $str = preg_replace('/([a-z])([A-Z])/', "\\1 \\2", $str);
        $str = preg_replace('@[^a-zA-Z0-9\-_ ]+@', '', $str);
        $str = str_replace($i, ' ', $str);
        $str = str_replace(' ', ' ', ucwords(strtolower($str)));
        return $str;
    }

    function generate_content($data, $type, $plugin_name = "" ){
        $result = ["status"=> "success", "data"=> ""];
        switch($type ){
            case "sql":
                $result["data"] = generate_content_sql($data );
                break;
            case "alter_sql":
                $result["data"] = generate_content_alter_sql($data);
                break;
            case "html":
                $result["data"] = generate_content_html($data ); 
                break;
            case "javascript":
                $result["data"] = generate_content_javascript($data ); 
                break;
            case "php":
                $result["data"] = generate_content_php($data ); 
                break;
            case "json":
                $result["data"] = generate_content_json($data );
                break;
            case "run":
                $result = run_content($data, "" );
                break;
            case "save":
                $result = save_content($data, $plugin_name );
                break;
            case "alter_save":
                $result = alter_save_content($data, $plugin_name);
                break;
        } 
        return $result;
    }

    function save_content($data, $plugin_name ){
        return run_content($data, $plugin_name );
    }

    function alter_save_content($data, $plugin_name){
        $table_name = $data["table_name"];

        $sql = generate_content_alter_sql($data, false );
        $db = $GLOBALS["db"];
        $db->run_query($sql );

        $sql_file = $table_name . "_" . date("y_m_d_h_i_s")  . ".sql";
        $sql_path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/" . $plugin_name .  "/temporary/{$sql_file}";

        if (file_exists($sql_path )){
            unlink($sql_path );
        }
        $myfile = fopen($sql_path, "w") or die("Unable to open file!");
        fwrite($myfile, $sql );
        fclose($myfile);

        return ["status"=> "success", "data"=> $table_name];
    }

    function run_content($data, $plugin_name = ""){
        $table_name = $data["table_name"];

        $tmp_sql = generate_content_tmp_sql($data, false );
        $sql = generate_content_sql($data, false );
        //$html = generate_content_html($data );
        //$js = generate_content_javascript($data );
        //$php = generate_content_php($data );
        //$json = generate_content_json($data );

        $drop_sql = "drop table {$table_name}";
        $run_sql = generate_content_sql($data, true );
        $db = $GLOBALS["db"];
        $db->run_query($drop_sql );
        $db->run_query($run_sql );

        //$html_file = $table_name . ".php";
        //$html_path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/" . $plugin_name . "/interfaces/admin/" . $html_file; 


        $temp_sql_file = $table_name . "_" . date("y_m_d_h_i_s")  . ".sql";
        $temp_sql_path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/" . $plugin_name .  "/temporary/{$temp_sql_file}";

        $sql_file = $table_name . "_sql.php";
        $sql_path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/" . $plugin_name .  "/interfaces/php/" . $sql_file;
        //$php_file = $table_name . ".php";
        //$php_path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/" . $plugin_name . "/interfaces/php/" . $php_file;
        //$js_file = $table_name . ".js";
        //$js_path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/" . $plugin_name . "/assets/js/" . $js_file;
        //$json_file = $table_name . ".json";
        //$json_path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/" . $plugin_name . "/settings/tables/" . $json_file;

        if (file_exists($temp_sql_path )){
            unlink($temp_sql_path );
        }
        $myfile = fopen($temp_sql_path, "w") or die("Unable to open file!");
        fwrite($myfile, $tmp_sql );
        fclose($myfile);

        if (file_exists($sql_path )){
            unlink($sql_path );
        }
        $myfile = fopen($sql_path, "w") or die("Unable to open file!");
        fwrite($myfile, $sql );
        fclose($myfile);

        // if (file_exists($html_path )){
        //     unlink($html_path );
        // }
        // $myfile = fopen($html_path, "w") or die("Unable to open file!");
        // fwrite($myfile, $html );
        // fclose($myfile);

        // if (file_exists($php_path )){
        //     unlink($php_path );
        // }
        // $myfile = fopen($php_path, "w") or die("Unable to open file!");
        // fwrite($myfile, $php );
        // fclose($myfile);

        // if (file_exists($js_path )){
        //     unlink($js_path );
        // }
        // $myfile = fopen($js_path, "w") or die("Unable to open file!");
        // fwrite($myfile, $js );
        // fclose($myfile);

        // if (file_exists($json_path )){
        //     unlink($json_path );
        // }
        // $myfile = fopen($json_path, "w") or die("Unable to open file!");
        // fwrite($myfile, $json );
        // fclose($myfile);

        return ["status"=> "success", "data"=> $table_name];
    }

    function generate_content_json($data, $flag = true){
        return json_encode($data);
    }

    function generate_content_tmp_sql($data, $flag = true ){
        $refs = isset($data["refs"]) ? $data["refs"] : [];
        $table_name = $data["table_name"];
        $primary_key = $data["primary_key"];
        $columns = $data["columns"];
        $endln = $flag ? "\n" : "";
        $tab1 = $flag ? "\t" : "";
        $tab2 = $flag ? "\t\t" : "";
        $tab3 = $flag ? "\t\t\t" : "";
        $tab4 = $flag ? "\t\t\t\t" : "";
        $tab5 = $flag ? "\t\t\t\t\t" : "";
        $tab6 = $flag ? "\t\t\t\t\t\t" : "";

        $str = "CREATE TABLE IF NOT EXISTS `{$table_name}`({$endln}{$tab1}`{$primary_key}` int(10) NOT NULL auto_increment";
        foreach($columns as $col ){
            extract($col );
            $field_item = "`{$title}` {$type}";
            if ($requried ){
                $field_item .= " NOT NULL";
            }else{
                $field_item .= " NULL";
            }
            if ($default_value ){
                $field_item .= " DEFAULT '{$default_value}'";
            }
            $str .= ", {$endln}{$tab1} {$field_item }";
        }
        $str .= ", {$endln}{$tab1} `created_id` int NULL";
        $str .= ", {$endln}{$tab1} `created_at` datetime NULL";
        $str .= ", {$endln}{$tab1} `updated_id` int NULL";
        $str .= ", {$endln}{$tab1} `updated_at` timestamp";

        $str .= ",{$endln}{$tab1}PRIMARY KEY(`{$primary_key}`){$endln});";
        foreach($refs as $ref){ 
            $str .= " {$endln}alter table `{$table_name}` add foreign key (`{$ref['field']}`) references {$ref['ref_table']} ({$ref['ref_field']});";
        }

        return $str;
    }

    function generate_content_alter_sql($data, $flag = true){
        $endln = $flag ? "\n" : "";
        $tab1 = $flag ? "\t" : "";

        $new_columns = isset($data["new_columns"]) ? $data["new_columns"] : [];
        $alter_columns = isset($data["alter_columns"]) ? $data["alter_columns"] : [];
        $del_columns = isset($data["del_columns"]) ? $data["del_columns"] : [];
        $refs = isset($data["refs"]) ? $data["refs"] : [];
        $drop_refs = isset($data["drop_refs"]) ? $data["drop_refs"] : [];
        $table_name = $data["table_name"];

        $new_query = "";
        $flag = true;
        foreach($new_columns as $key=>$item){
            extract($item);
            $comma = $flag ? "" : ",";
            $flag = false;
            $new_query .= "{$comma} {$endln}{$tab1} ADD `{$title}` {$type} NULL";
        }

        $alter_query = "";
        $flag = true;
        foreach($alter_columns as $item){
            extract($item);
            $comma = $flag ? "" : ",";
            $flag = false;
            $alter_query .= "{$comma} {$endln}{$tab1} CHANGE COLUMN `{$origin_field}` `{$field}` {$type}";
        }

        $del_query = "";
        $flag = true;
        foreach($del_columns as $item){
            $comma = $flag ? "" : ",";
            $flag = false;
            $del_query .= "{$comma} {$endln}{$tab1} DROP COLUMN `{$item}`";
        }

        $ref_query = "";
        $flag = true;
        foreach($refs as $item){
            extract($item);
            $comma = $flag ? "" : ",";
            $flag = false;
            $ref_query .= "{$comma} {$endln} {$tab1} ADD CONSTRAINT {$field}_fk FOREIGN KEY ({$field}) REFERENCES {$ref_table}({$ref_field})";
        }

        $drop_ref_query = "";
        $flag = true;
        foreach($drop_refs as $item){
            $comma = $flag ? "" : ",";
            $flag = false;
            $drop_ref_query .= "{$comma} {$endln} {$tab1} DROP FOREIGN KEY `{$item}`";
        }

        $query = "ALTER TABLE {$table_name} ";
        $comma = "";

        if ($drop_ref_query != ""){
            $query .= $comma . $drop_ref_query;
            $comma = ",";
        }

        if ($del_query != ""){
            $query .= $comma . $del_query;
            $comma = ",";
        }

        if ($alter_query != ""){
            $query .= $comma . $alter_query;
            $comma = ",";
        }

        if ($new_query != ""){
            $query .= $comma . $new_query;
            $comma = ",";
        }

        if ($ref_query != ""){
            $query .= $comma . $ref_query;
        }
        return $query;
    }

    function generate_content_sql($data, $flag = true ){
        $refs = isset($data["refs"]) ? $data["refs"] : [];
        $table_name = $data["table_name"];
        $primary_key = $data["primary_key"];
        $columns = $data["columns"];
        $endln = $flag ? "\n" : "";
        $tab1 = $flag ? "\t" : "";
        $tab2 = $flag ? "\t\t" : "";
        $tab3 = $flag ? "\t\t\t" : "";
        $tab4 = $flag ? "\t\t\t\t" : "";
        $tab5 = $flag ? "\t\t\t\t\t" : "";
        $tab6 = $flag ? "\t\t\t\t\t\t" : "";

        $php_str = $flag ? "": '<?php $query = "';
        $php_str_end = $flag ? "" : '" ?>';
        $str = $php_str . "CREATE TABLE IF NOT EXISTS `{$table_name}`({$endln}{$tab1}`{$primary_key}` int(10) NOT NULL auto_increment";
        foreach($columns as $col ){
            extract($col );
            $field_item = "`{$title}` {$type}";
            if ($requried ){
                $field_item .= " NOT NULL";
            }else{
                $field_item .= " NULL";
            }
            if ($default_value ){
                $field_item .= " DEFAULT '{$default_value}'";
            }
            $str .= ", {$endln}{$tab1} {$field_item }";
        }
        $str .= ", {$endln}{$tab1} `created_id` int NULL";
        $str .= ", {$endln}{$tab1} `created_at` datetime NULL";
        $str .= ", {$endln}{$tab1} `updated_id` int NULL";
        $str .= ", {$endln}{$tab1} `updated_at` timestamp";

        $str .= ",{$endln}{$tab1}PRIMARY KEY(`{$primary_key}`){$endln});";
        foreach($refs as $ref){ 
            $str .= " {$endln}alter table `{$table_name}` add foreign key (`{$ref['field']}`) references {$ref['ref_table']} ({$ref['ref_field']});";
        }

        $str .= $php_str_end;

        return $str;
    }

    function generate_content_html($data, $flag = true ){
        $db = $GLOBALS["db"];

        $endln = $flag ? "\n" : "";
        $tab1 = $flag ? "\t" : "";
        $tab2 = $flag ? "\t\t" : "";
        $tab3 = $flag ? "\t\t\t" : "";
        $tab4 = $flag ? "\t\t\t\t" : "";
        $tab5 = $flag ? "\t\t\t\t\t" : "";
        $tab6 = $flag ? "\t\t\t\t\t\t" : "";

        $table_name = $data["table_name"];
        $primary_key = $data["primary_key"];
        $columns = $data["columns"];

        $header = '<script src="//cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>' . "\n";
        $header .= '<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">';
        //$header .= '<script type="text/javascript" charset="utf-8" src="assets/js/apis/' . $table_name . '.js"></script>' . "\n";
        $header .= '<script type="text/javascript" charset="utf-8" src="assets/js/' . $table_name . '.js"></script>' . "\n";

        $body = "<div class='main-body'>" . "\n";
            $body .= $tab1 . '<h1 class="mt-1r">DataTables Editor <span>' . $table_name . '</span></h1>' . "\n";
            $body .= $tab1 . '<div class="row mt-1r mb-1r"><div class="col-md-12"><button class="btn btn-success" id="' . $table_name . '_new">New</button><button class="btn btn-success" id="export_excel">Export</button></div></div>' . "\n";
            $body .= $tab1 . '<div class="row mt-2r">' . "\n";
                $body .= $tab2 . '<div class="col-md-12">' . "\n";
                    $body .= $tab2 . '<table cellpadding="0" cellspacing="0" border="0" class="display" id="' . $table_name . '_table" width="100%">' . "\n"; 
                        $body .= $tab3 . '<thead><tr>' . "\n";
                            foreach($columns as $col ){
                                $col_title = camelCase($col['title']);
                                $body .= $tab4 . "<th>{$col_title}</th>" . "\n";
                            }
                            $body .= $tab4 . "<th>Action</th>" . "\n";
                        $body .= $tab3 . '</tr></thead>' . "\n";
                        $body .= $tab3 . "<tbody id='" . $table_name . "_body'>" . "\n";
                        $body .= $tab3 . "</tbody>" . "\n";
                    $body .= $tab2 . '</table>' . "\n";
                $body .= $tab2 . '</div>' . "\n";
            $body .= $tab1 . "</div>" . "\n";
        $body .= "</div>" . "\n";

        // modal div
        $body .= '<div class="modal column-detail-modal" tabindex="-1" role="dialog" id="edit-modal">' . "\n";
            $body .= $tab1 . '<div class="modal-dialog modal-lg" role="document">' . "\n";
                $body .= $tab2 . '<div class="modal-content">' . "\n";
                    $body .= $tab3 . '<div class="modal-header">' . "\n";
                        $body .= $tab4 . '<h5 class="modal-title">' . $table_name . ' Table</h5>' . "\n";
                        $body .= $tab4 . '<button type="button" class="close" data-dismiss="modal" aria-label="Close">' . "\n";
                            $body .= $tab5 . '<span aria-hidden="true">&times;</span>' . "\n";
                        $body .= $tab4 . '</button>' . "\n";
                    $body .= $tab3 . '</div>' . "\n";

                    $body .= $tab3 . '<form class="form">' . "\n";
                        $body .= $tab3 . '<div class="modal-body">' . "\n";
                            foreach($columns as $col ){
                                extract($col );
                                $body .= $tab4 . '<div class="form-group row">' . "\n";
                                    $body .= $tab5 . '<label for="field-default-value" class="col-sm-2 col-form-label text-right">' . camelCase($title) . '</label>' . "\n";
                                    $body .= $tab5 . '<div class="col-sm-10">' . "\n";
                                        if ($ref_table != "" && $ref_field != "" ){
                                            $body .= $tab5 . "<select class='form-control' data-reffield='" . $ref_field . "' data-reftable='" . $ref_table . "' data-table='" . $table_name . "' data-type='relation' id='" . $table_name . '_field_' . $title . "'>\n";
                                                /*$table_data = $db->load_data($ref_table );
                                                while($row = $table_data->fetch(PDO::FETCH_ASSOC)){
                                                    $str = " - ";
                                                    foreach($row as $cell){
                                                        $str .= $cell . " - ";
                                                    }
                                                    $body .= $tab6 . "<option value='" . $row[$ref_field] . "'>" . $str . "</option>";
                                                }*/
                                            $body .= $tab5 . "</select>";
                                        }else if ($type == 'boolean'){
                                            $body .= $tab5 . '<input type="checkbox" class="form-control" data-type="checkbox" id="' . $table_name . '_field_' . $title . '">' . "\n";
                                        }else if($type == 'date' || $type == 'datetime'){
                                            $body .= $tab5 . '<input type="text" class="form-control" data-type="date" id="' . $table_name . '_field_' . $title . '">' . "\n";
                                        }else if($type == 'varchar(300)'){
                                            //$body .= '<input type="file" class="form-control" data-type="file" id="' . $table_name . '_field_' . $title . '">' . "\n";
                                            $body .= $tab5 . '<div id="' . $table_name . '_field_' . $title . '_upload" data-type="file">Select File</div>';
                                            $body .= $tab5 . '<button class="btn btn-primary" type="button" id="' . $table_name . '_field_' . $title . '_btn">Upload</button>';
                                        }else if($type == 'text'){
                                            $body .= $tab5 . '<textarea class="form-control" data-type="string" id="' . $table_name . '_field_' . $title . '"></textarea>' . "\n";
                                        }else {
                                            $body .= $tab5 . '<input type="text" class="form-control" data-type="string" id="' . $table_name . '_field_' . $title . '">' . "\n";
                                        }
                                    $body .= $tab4 . '</div>' . "\n";
                                $body .= $tab3 . '</div>' . "\n";
                            }
                        $body .= $tab3 . '</div>' . "\n";
                    $body .= $tab2 . '</form>' . "\n";

                    $body .= $tab1 . '<div class="modal-footer">' . "\n";
                        $body .= $tab3 . '<input type="hidden" id="data-id" value="-1"/>' . "\n";
                        $body .= $tab3 . '<button type="button" class="btn btn-primary" id="save_record">Save</button>' . "\n";
                        $body .= $tab3 . '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>' . "\n";
                    $body .= $tab3 . '</div>' . "\n";
                $body .= $tab2 . '</div>' . "\n";
            $body .= $tab1 . '</div>' . "\n";
        $body .= '</div>' . "\n";

        $html = $header.$body;
        return $html;
    }

    function generate_content_javascript($data, $flag = true ){
        $endln = $flag ? "\n" : "";
        $tab1 = $flag ? "\t" : "";
        $tab2 = $flag ? "\t\t" : "";
        $tab3 = $flag ? "\t\t\t" : "";
        $tab4 = $flag ? "\t\t\t\t" : "";
        $tab5 = $flag ? "\t\t\t\t\t" : "";
        $tab6 = $flag ? "\t\t\t\t\t\t" : "";
        
        $table_name = $data["table_name"];
        $primary_key = $data["primary_key"];
        $columns = $data["columns"];

        $uploads = [];

        $js = 'base_url = "/plugins/' . PLUGIN_PATH . '/interfaces/php/' . $table_name . '.php";';
        $js .= $endln . 'upload_url = "/plugins/plugin_builder/include/classes/upload.php";';
        $js .= $endln . 'export_url = "/plugins/plugin_builder/include/classes/export_excel.php";';
        $js .= $endln . 'var table;';
        $js .= $endln . 'var sel_tr;';
        $js .= $endln . '$(document).ready(function(){';
            $js .= $endln . $tab1 . 'init_table();';
            $js .= $endln . $tab1 . '$("#' . $table_name . '_new").on("click", new_record);';
            $js .= $endln . $tab1 . '$("#' . $table_name . '_body").on("click", ".edit-item", edit_record );';
            $js .= $endln . $tab1 . '$("#' . $table_name . '_body").on("click", ".delete-item", delete_record );';
            $js .= $endln . $tab1 . '$("#export_excel").on("click", export_excel );';
            $js .= $endln . $tab1 . '$("#save_record").on("click", save_record );';
            //$js .= $endln . $tab1 . '$("body").on("click", ".ajax-file-upload-red", function(e){e.preventDefault(); $(this).parent().remove()});';
            $js .= $endln . $tab1 . '$("body").on("click", ".ajax-file-upload-red", function(e){';
                $js .= $endln . $tab2 . 'e.preventDefault();';
                $js .= $endln . $tab2 . '$(this).parent().parent().find("+ .btn").show();';
                $js .= $endln . $tab2 . '$(this).parent().parent().parent().find("div[data-type=file]").attr("data-file", "").show();';
                $js .= $endln . $tab2 . '$(this).parent().remove()';
            $js .= $endln . $tab1 . '});';
            $js .= $endln . $tab1 . '$("textarea").trumbowyg();';
            $js .= $endln . $tab1 . 'var objs = $("select[data-type=relation]");';
            $js .= $endln . $tab1 . 'for(var i = 0; i < objs.length; i++ ){';
                $js .= $endln . $tab2 . 'var obj = objs[i];';
                $js .= $endln . $tab2 . 'var obj_id = $(obj ).attr("id");';
                $js .= $endln . $tab2 . 'var ref_table = $(obj).attr("data-reftable");';
                $js .= $endln . $tab2 . 'var ref_field = $(obj).attr("data-reffield");';
                $js .= $endln . $tab2 . 'set_relation_table_data(obj_id, ref_table, ref_field );';
            $js .= $endln . $tab1 . '}';

        $js .= $endln . '});';
        
        $js .= $endln . 'function export_excel(){';
            $js .= $endln . $tab1 . '$.ajax({';
                $js .= $endln . $tab2 . 'url: export_url,';
                $js .= $endln . $tab2 . 'data:{';
                    $js .= $endln . $tab3 . 'table: "' . $table_name . '",';
                $js .= $endln . $tab2 . '},';
                $js .= $endln . $tab2 . 'type: "post",';
                $js .= $endln . $tab2 . 'dataType: "json",';
                $js .= $endln . $tab2 . 'success: function(data){';
                    $js .= $endln . $tab3 . 'if (data["status"] == "success" ){';
                        $js .= $endln . $tab4 . 'window.open("/plugins/excels/" + data["file"], "_blank");';
                    $js .= $endln . $tab3 . '}else{';
                        $js .= $endln . $tab4 . 'toastr.error("failed");';
                        $js .= $endln . $tab3 . '}';
                $js .= $endln . $tab2 . '}';
            $js .= $endln . $tab1 . '});';
        $js .= $endln . '}';

        $js .= $endln . 'function save_record(){';
            $js .= $endln . $tab1 . 'var id = $("#data-id").val();';
            foreach($columns as $col ){
                extract($col );
                if ($type == 'varchar(300)'){
                    array_push($uploads, $title );
                    $js .= $endln . $tab1 . 'var tr_' . $title . ' = $("#' . $table_name . '_field_' . $title . '_upload").attr("data-file");';
                }else if($type == 'text'){
                    $js .= $endln . $tab1 . 'var tr_' . $title . ' = $("#' . $table_name . '_field_' . $title . '").trumbowyg(\'html\');';
                }else{
                    $js .= $endln . $tab1 . 'var tr_' . $title . ' = $("#' . $table_name . '_field_' . $title . '").val();';
                }
            }
            $js .= $endln . $tab1 . '$.ajax({';
                $js .= $endln . $tab2 . 'url: base_url,';
                $js .= $endln . $tab2 . 'data:{';
                    $js .= $endln . $tab3 . 'type: "save",';
                    $js .= $endln . $tab3 . 'id: id,';
                    foreach($columns as $col ){
                        extract($col );
                        $js .= $endln . $tab3 . $title . ': tr_' . $title . ",";
                    }
                $js .= $endln . $tab2 . '},';
                $js .= $endln . $tab2 . 'type: "post",';
                $js .= $endln . $tab2 . 'dataType: "json",';
                $js .= $endln . $tab2 . 'success: function(data){';
                    $js .= $endln . $tab3 . 'if (data["status"] == "success" ){';
                        $js .= $endln . $tab4 . 'if (id == "-1"){';
                            $js .= $endln . $tab5 . 'var table_id = data["id"];';
                            $js .= $endln . $tab5 . 'table.row.add( [';
                            foreach($columns as $col ){
                                extract($col );
                                if ($type == "varchar(300)"){
                                    $js .= '"<img width=\'100\' data-file=\'" + tr_' . $title . '+"\' class=\'' . $table_name . '_' . $title . '\' src=\'/plugins/uploads/" + tr_' . $title . ' + "\'>", ';
                                }else{
                                    $js .= '"<div class=\'' . $table_name . '_' . $title . '\'>" + tr_' . $title . ' + "</div>", ';
                                }                                
                            }//elete-item" data-id="' + table_id + '"
                            $js .= "'" . '<button class="btn btn-xs btn-sm btn-primary mr-6 edit-item" data-id="\'' .
                            " + table_id + '" . '"><i class="fa fa-edit"></i></button><button class="btn btn-xs btn-sm btn-secondary delete-item" data-id="' . "'+ table_id + '" . '"><i class="fa fa-trash"></i></button>' . "'" . ']).draw( false );';
                        $js .= $endln . $tab4 . '}else{';
                            foreach($columns as $col ){
                                extract($col );
                                if ($type == 'varchar(300)'){
                                    $js .= $endln . $tab5 . '$(sel_tr).find(".' . $table_name. '_' . $title . '").attr("width", "100").attr("data-file", tr_' . $title . ').attr("src", "/plugins/uploads/" + tr_' . $title . ');';
                                }else{
                                    $js .= $endln . $tab5 . '$(sel_tr).find(".' . $table_name. '_' . $title . '").html(tr_' . $title . ' );';
                                }
                            }
                        $js .= $endln . $tab4 . '}';
                        $js .= $endln . $tab4 . '$("#edit-modal").modal("hide");';
                    $js .= $endln . $tab3 . '}';
                $js .= $endln . $tab2 . '}';

            $js .= $endln . $tab1 . '});';
        $js .= $endln . '}';

        $js .= $endln . 'function new_record(){';
            $js .= $endln . $tab1.  '$("#edit-modal input").val("");';
            $js .= $endln . $tab1 . '$(".ajax-file-upload-statusbar").remove();';
            $js .= $endln . $tab1 . '$("[data-type=file]").show();';
            $js .= $endln . $tab1 . '$("[data-type=file]").parent().find("button").show();';
            $js .= $endln . $tab1 . '$("#data-id").val("-1");';
            $js .= $endln . $tab1 . '$("#edit-modal").modal("show");';
        $js .= $endln . '}';

        $js .= $endln . 'function delete_record(){';
            $js .= $endln . $tab1 . 'var id = $(this).attr("data-id");';
            $js .= $endln . $tab1 . 'sel_tr = $(this).parent().parent();';
            $js .= $endln . $tab1 . 'if (confirm("Are you going to delete this record?")){';
                $js .= $endln . $tab2 . '$.ajax({';
                    $js .= $endln . $tab3 . 'url: base_url,';
                    $js .= $endln . $tab3 . 'data:{';
                        $js .= $endln . $tab4 . "type: 'delete',";
                        $js .= $endln . $tab4 . "id: id";
                    $js .= $endln . $tab3 . '},';
                    $js .= $endln . $tab3 . 'type:"post",';
                    $js .= $endln . $tab3 . 'dataType: "json",';
                    $js .= $endln . $tab3 . 'success: function(data){';
                        $js .= $endln . $tab4 . 'if (data["status"] == "success"){';
                            $js .= $endln . $tab5 . "table.row('.selected').remove().draw( false );";
                        $js .= $endln . $tab4 . '}';
                    $js .= $endln . $tab3 . '}';
                $js .= $endln . $tab2 . '})';
            $js .= $endln . $tab1 . '}';
        $js .= $endln . '}';

        $js .= $endln . 'function edit_record(){';
            $js .= $endln . $tab1 . '$(".ajax-file-upload-statusbar").remove();';
            $js .= $endln . $tab1 . "var id = $(this).attr('data-id');";
            $js .= $endln . $tab1 . "sel_tr = $(this).parent().parent();";
            $js .= $endln . $tab1 . '$("#data-id").val(id );';
            foreach($columns as $col ){
                extract($col );
                if ($type == "varchar(300)"){
                    if ($title && $title != "" ){
                        $js .= $endln . $tab1 . 'var img_file = $(sel_tr).find(".' . $table_name . '_' . $title . '").attr("data-file");';
                        $js .= $endln . $tab1 . 'if (img_file && img_file != "" ){';
                            $js .= $endln . $tab2 . 'var container = $("#' . $table_name . '_field_' . $title . '_upload + .ajax-file-upload-container");';
                            $js .= $endln . $tab2 . 'var status = $("<div>").addClass("ajax-file-upload-statusbar").appendTo(container );';
                            $js .= $endln . $tab2 . '$("<img>").addClass("ajax-file-upload-file-img").attr("src", "/plugins/uploads/" + img_file ).appendTo(status);';
                            $js .= $endln . $tab2 . '$("<div>").addClass("ajax-file-upload-red").text("Delete").appendTo(status );';
                            $js .= $endln . $tab2 . '$("#' . $table_name . '_field_' . $title . '_upload").attr("data-type", "file").attr("data-file", img_file);';
                            $js .= $endln . $tab2 . '$("#' . $table_name . '_field_' . $title . '_upload").hide();';
                            $js .= $endln . $tab2 . '$("#' . $table_name . '_field_' . $title . '_btn").hide();';
                        $js .= $endln . $tab1 . '}';
                    }
                }else if($type == "text"){
                    $js .= $endln . $tab1 . '$("#' . $table_name . '_field_' . $title . '").trumbowyg("html",$(sel_tr).find(".' . $table_name . '_' . $title . '").html());';
                }else{
                    $js .= $endln . $tab1 . '$("#' . $table_name . '_field_' . $title . '").val($(sel_tr).find(".' . $table_name . '_' . $title . '").html());';
                }
            }
            $js .= $endln . $tab1 . '$("#edit-modal").modal("show");';
        $js .= $endln . '}';

        $js .= $endln . 'function init_table(){';
            $js .= $endln . $tab1 . '$.ajax({';
                $js .= $endln . $tab2 . 'url: base_url,';
                $js .= $endln . $tab2 . 'data:{';
                    $js .= $endln . $tab3 . 'type: "init_table"';
                $js .= $endln . $tab2 . '},';
                $js .= $endln . $tab2 . 'dataType: "json",';
                $js .= $endln . $tab2 . 'type: "post",';
                $js .= $endln . $tab2 . 'success: function(data ){';
                    $js .= $endln . $tab3 . 'if (data["status"] == "success" ){';
                        $js .= $endln . $tab4 . 'load_data(data["data"]);';
                    $js .= $endln . $tab3 . '}';
                $js .= $endln . $tab2 . '}';
            $js .= $endln . $tab1 . '});';
        $js .= $endln . '}';

        $js .= $endln . 'function load_data(data ){';
            $js .= $endln . $tab1 . 'var parent = $("#' . $table_name . '_body");';
            $js .= $endln . $tab1 . 'for(var i = 0; i < data.length; i++ ){';
                $js .= $endln . $tab2 . 'var item = data[i];';
                $js .= $endln . $tab2 . "var tr = $('<tr>').attr('data-id', item[0]).appendTo(parent );";
                foreach($columns as $key=> $col ){
                    extract($col );
                    if ($type == "varchar(300)"){
                        $js .= $endln . $tab2 . 'td = $("<td>").appendTo(tr);';
                        $js .= $endln . $tab2 . '$("<img>").attr("width", "100").attr("data-file", item[' . ($key + 1) . ']).attr("src", "/plugins/uploads/" + item[' . ($key + 1) . ']).addClass("' . $table_name . '_' . $title . '").appendTo(td);';
                    }else{
                        $js .= $endln . $tab2 . 'td = $("<td>").appendTo(tr);';
		                $js .= $endln . $tab2 . '$("<div>").addClass("' . $table_name . '_' . $title . '").html(item[' . ($key + 1). ']).appendTo(td);';
                    }
                }
                $js .= $endln . $tab2 . 'var td = $("<td>").appendTo(tr );';
                $js .= $endln . $tab2 . '$("<button>").addClass("btn btn-xs btn-sm btn-primary mr-6 edit-item")';
                            $js .= $endln . $tab3 . '.attr("data-id", item[0])';
                            $js .= $endln . $tab3 . '.html("<i class=' . "'fa fa-edit'" . '></i>").appendTo(td );';
                $js .= $endln . $tab2 . '$("<button>").addClass("btn btn-xs btn-sm btn-secondary delete-item")';
                            $js .= $endln . $tab3 . '.attr("data-id", item[0])';
                            $js .= $endln . $tab3 . '.html("<i class=' . "'fa fa-trash'" . '></i>").appendTo(td );';
            $js .= $endln . $tab1 . '}';
            $js .= $endln . $tab1 . 'table = $("#' . $table_name . '_table").DataTable();';
        
            $js .= $endln . $tab1 . "$('#" . $table_name . "_table tbody').on( 'click', 'tr', function () {";
                $js .= $endln . $tab2 . "if ( $(this).hasClass('selected') ) {";
                    $js .= $endln . $tab3 . "$(this).removeClass('selected');";
                $js .= $endln . $tab2 . "}";
                $js .= $endln . $tab2 . "else {";
                    $js .= $endln . $tab2 . "table.$('tr.selected').removeClass('selected');";
                    $js .= $endln . $tab2 . "$(this).addClass('selected');";
                $js .= $endln . $tab2 . "}";
            $js .= $endln . $tab1 . "});";
        $js .= $endln . "}"; 

        $js .= $endln . '$(document).ready(function(){';
            foreach($uploads as $item ){
                $js .= $endln . $tab1 . 'var extraObj = $("#' . $table_name . '_field_' . $item . '_upload").uploadFile({';
                    $js .= $endln .$tab2 . 'url:upload_url, fileName:"apifile", autoSubmit:false,returnType:"json",';
                    $js .= 'onSuccess:function(files,data,xhr,pd){';
                        $js .= 'if (data["status"] == "success"){$("#' . $table_name . '_field_' . $item . '_upload").attr("data-file", data["file"] );}';
                        $js .= 'else{$("#' . $table_name . '_field_' . $item . '_upload").attr("data-file", "" );}';
                    $js .= '}});';
                $js .= $endln . $tab1 . '$("#' . $table_name . '_field_' . $item . '_btn").click(function(){extraObj.startUpload();});';
            }

        $js .= $endln . '});';

        return $js;
    }

    function generate_content_php($data, $flag = true ){
        $endln = $flag ? "\n" : "";
        $tab1 = $flag ? "\t" : "";
        $tab2 = $flag ? "\t\t" : "";
        $tab3 = $flag ? "\t\t\t" : "";
        $tab4 = $flag ? "\t\t\t\t" : "";
        $tab5 = $flag ? "\t\t\t\t\t" : "";
        $tab6 = $flag ? "\t\t\t\t\t\t" : "";

        $table_name = $data["table_name"];
        $primary_key = $data["primary_key"];
        $columns = $data["columns"];

        $tmp = "";
        $tmp_key = "";
        foreach($columns as $key=> $col ){
            extract($col);
            if ($key == 0 ){
                $tmp .= $title . "='" .'{$' . $title . "}'";
                $tmp_key .= "$" . $title;
            }else{
                $tmp .= "," . $title . "='" . '{$' . $title . "}'";
                $tmp_key .= "," . "$" . $title;
            }
        }

        $php  = '<?php';
            $php .= $endln . $tab1 .  'include_once("../../../../config/config.php");';
            $php .= $endln . $tab1 .  'include_once("./' . $table_name . '_sql.php");';
            $php .= "include_once '../../../../config/database.php';";
            $php .= '$db = new Database();';
            $php .= '$db->getConnection(API_DB_NAME );';
            $php .= $endln . $tab1 .  'extract($_POST);';
            $php .= $endln . $tab1 .  'switch($type ){';
                $php .= $endln . $tab2 . 'case "init_table":';
                    $php .= $endln . $tab3 . 'init_table();';
                    $php .= $endln . $tab3 . 'break;';
                $php .= $endln . $tab2 .  'case "delete":';
                    $php .= $endln . $tab3 . 'delete_tr($id);';
                    $php .= $endln . $tab3 . 'break;';
                $php .= $endln . $tab2 .  'case "save":';
                    $php .= $endln . $tab3 .  'save_tr($id ';
                        foreach($columns as $col ){
                            extract($col );
                            $php .= ",$" . $title;
                        }
                    $php .= ');';
                    $php .= $endln . $tab3 . 'break;';
            $php .= $endln . $tab1 . '}';
            
            $php .= $endln . 'function init_table(){';
                $php .= $endln . $tab1 . '$query = $GLOBALS["query"];';
                $php .= $endln . $tab1 . '$db = $GLOBALS["db"];';
                $php .= $endln . $tab1 . '$result = $db->load_data("' . $table_name . '");';
        
                $php .= $endln . $tab1 . '$data = [];';
                $php .= $endln . $tab1 . 'if($result){';
                    $php .= $endln . $tab2 . 'while ($row = $result->fetch(PDO::FETCH_BOTH)){';
                        $php .= $endln . $tab3 . '$item = [];';
                        $php .= $endln . $tab3 . 'array_push($item, $row["id"]);';
                        foreach($columns as $col ){
                            extract($col );
                            $php .= $endln . $tab3 . 'array_push($item, $row["' . $title . '"]);';
                        }
                        $php .= $endln . $tab3 . 'array_push($data, $item );';
                    $php .= $endln . $tab2 . '}';
                $php .= $endln . $tab1 . '}';
                $php .= $endln . $tab1 . 'echo json_encode(["status"=>"success", "data"=> $data ]);';
            $php .= $endln . '}';

            $php .= $endln . 'function delete_tr($id ){';
                $php .= $endln . $tab1 . '$query = "delete from ' . $table_name . ' where ' . $primary_key . '={$id}";';
                $php .= $endln . $tab1 . '$db = $GLOBALS["db"];';
                $php .= $endln . $tab1 . '$db->run_query($query );';
                $php .= $endln . $tab1 . 'echo json_encode(["status"=> "success"]);';
            $php .= $endln . '}';

            $php .= $endln . 'function save_tr($id, ' . $tmp_key . '){';
                $php .= $endln . $tab1 . '$db = $GLOBALS["db"];';
                $php .= $endln . $tab1 . 'if ($id == "-1"){';
                    $php .= $endln . $tab2 . '$query = "insert into ' . $table_name . ' set ' . $tmp . '";';
                $php .= $endln . $tab1 . '}else{';
                    $php .= $endln . $tab2 . '$query = "update ' . $table_name . ' set ' . $tmp . ' where ' . $primary_key . '={$id}";';
                $php .= $endln . $tab1 . '}';
                $php .= $endln . $tab1 . '$id = $db->update_query($query );';
                $php .= $endln . $tab1 . 'echo json_encode(["status"=> "success", "' . $primary_key . '"=> $id ]);';
            $php .= $endln . '}';

        $php .= $endln . "?>";
        return $php;
    }
?>