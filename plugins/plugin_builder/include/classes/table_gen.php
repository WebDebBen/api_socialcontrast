<?php
    function generate_content($data, $type ){
        $result = ["status"=> "success", "data"=> ""];
        switch($type ){
            case "sql":
                $result["data"] = generate_content_sql($data );
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
                $result = run_content($data );
                break;
            case "save":
                $result = save_content($data );
                break;
        } 
        return $result;
    }

    function save_content($data ){
        return run_content($data );
    }

    function run_content($data ){
        $table_name = $data["table_name"];

        $sql = generate_content_sql($data, false );
        $html = generate_content_html($data );
        $js = generate_content_javascript($data );
        $php = generate_content_php($data );
        $json = generate_content_json($data );

        $drop_sql = "drop table {$table_name}";
        $run_sql = generate_content_sql($data, true );
        $db = $GLOBALS["db"];
        $db->run_query($drop_sql );
        $db->run_query($run_sql );

        $html_file = $table_name . ".php";
        $html_path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/" . PLUGIN_PATH . "/interfaces/admin/" . $html_file; 
        // "../../../../plugins/" . PLUGIN_PATH . "/interfaces/admin/" . $html_file;
        $sql_file = $table_name . "_sql.php";
        //$sql_path = "../../../../plugins/" . PLUGIN_PATH .  "/interfaces/php/" . $sql_file;
        $sql_path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/" . PLUGIN_PATH .  "/interfaces/php/" . $sql_file;
        $php_file = $table_name . ".php";
        //$php_path = "../../../../plugins/" . PLUGIN_PATH .  "/interfaces/php/" . $php_file;
        $php_path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/" . PLUGIN_PATH . "/interfaces/php/" . $php_file;
        $js_file = $table_name . ".js";
        //$js_path = "../../../../plugins/" . PLUGIN_PATH .  "/assets/js/" . $js_file;
        //$js_path = "../../../../cloudcms/theme/assets/js/apis/" . $js_file;
        $js_path = $_SERVER["DOCUMENT_ROOT"] . "/cloudcms/theme/assets/js/apis/" . $js_file;
        $json_file = $table_name . ".json";
        //$json_path = "../../../../plugins/" . PLUGIN_PATH . "/settings/tables/" . $json_file;
        $json_path = $_SERVER["DOCUMENT_ROOT"] . "/plugins/" . PLUGIN_PATH . "/settings/tables/" . $json_file;

        if (file_exists($sql_path )){
            unlink($sql_path );
        }
        $myfile = fopen($sql_path, "w") or die("Unable to open file!");
        fwrite($myfile, $sql );
        fclose($myfile);

        if (file_exists($html_path )){
            unlink($html_path );
        }
        $myfile = fopen($html_path, "w") or die("Unable to open file!");
        fwrite($myfile, $html );
        fclose($myfile);

        if (file_exists($php_path )){
            unlink($php_path );
        }
        $myfile = fopen($php_path, "w") or die("Unable to open file!");
        fwrite($myfile, $php );
        fclose($myfile);

        if (file_exists($js_path )){
            unlink($js_path );
        }
        $myfile = fopen($js_path, "w") or die("Unable to open file!");
        fwrite($myfile, $js );
        fclose($myfile);

        if (file_exists($json_path )){
            unlink($json_path );
        }
        $myfile = fopen($json_path, "w") or die("Unable to open file!");
        fwrite($myfile, $json );
        fclose($myfile);

        return ["status"=> "success", "data"=> $table_name];
    }

    function generate_content_json($data, $flag = true){
        return json_encode($data);
    }

    function generate_content_sql($data, $flag = true ){
        $table_name = $data["table_name"];
        $primary_key = $data["primary_key"];
        $columns = $data["columns"];
        $endln = $flag ? "\n" : "";
        $tab = $flag ? "\t" : "";

        $php_str = $flag ? "": '<?php $query = "';
        $php_str_end = $flag ? "" : '" ?>';
        $str = $php_str . "CREATE TABLE IF NOT EXISTS `{$table_name}`({$endln}{$tab}`{$primary_key}` int(10) NOT NULL auto_increment";
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
            $str .= ", {$endln}{$tab} {$field_item }";
        }
        $str .= ",{$endln}{$tab}PRIMARY KEY(`{$primary_key}`){$endln});";
        $str .= $php_str_end;
        return $str;
    }

    function generate_content_html($data, $flag = true ){
        $table_name = $data["table_name"];
        $primary_key = $data["primary_key"];
        $columns = $data["columns"];

        $header = '<script src="//cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>' . "\n";
        $header .= '<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">';
        $header .= '<script type="text/javascript" charset="utf-8" src="assets/js/apis/' . $table_name . '.js"></script>' . "\n";

        $body = "<div class='main-body'>" . "\n";
            $body .= '<h1 class="mt-1r">DataTables Editor <span>' . $table_name . '</span></h1>' . "\n";
            $body .= '<div class="row mt-1r mb-1r"><div class="col-md-12"><button class="btn btn-success" id="' . $table_name . '_new">New</button></div></div>' . "\n";
            $body .= '<div class="row mt-2r">' . "\n";
                $body .= '<div class="col-md-12">' . "\n";
                    $body .= '<table cellpadding="0" cellspacing="0" border="0" class="display" id="' . $table_name . '_table" width="100%">' . "\n"; 
                        $body .= '<thead><tr>' . "\n";
                            foreach($columns as $col ){
                                $body .= "<th>{$col['title']}</th>" . "\n";
                            }
                            $body .= "<th>Action</th>" . "\n";
                        $body .= '</tr></thead>' . "\n";
                        $body .= "<tbody id='" . $table_name . "_body'>" . "\n";
                        $body .= "</tbody>" . "\n";
                    $body .= '</table>' . "\n";
                $body .= '</div>' . "\n";
            $body .= "</div>" . "\n";
        $body .= "</div>" . "\n";

        // modal div
        $body .= '<div class="modal column-detail-modal" tabindex="-1" role="dialog" id="edit-modal">' . "\n";
            $body .= '<div class="modal-dialog" role="document">' . "\n";
                $body .= '<div class="modal-content">' . "\n";
                    $body .= '<div class="modal-header">' . "\n";
                        $body .= '<h5 class="modal-title">' . $table_name . ' Table</h5>' . "\n";
                        $body .= '<button type="button" class="close" data-dismiss="modal" aria-label="Close">' . "\n";
                            $body .= '<span aria-hidden="true">&times;</span>' . "\n";
                        $body .= '</button>' . "\n";
                    $body .= '</div>' . "\n";

                    $body .= '<form class="form">' . "\n";
                        $body .= '<div class="modal-body">' . "\n";
                            foreach($columns as $col ){
                                extract($col );
                                $body .= '<div class="form-group row">' . "\n";
                                    $body .= '<label for="field-default-value" class="col-sm-4 col-form-label text-right">' . $title . '</label>' . "\n";
                                    $body .= '<div class="col-sm-8">' . "\n";
                                        if ($type == 'boolean'){
                                            $body .= '<input type="checkbox" class="form-control" data-type="checkbox" id="' . $table_name . '_field_' . $title . '">' . "\n";
                                        }else if($type == 'date' || $type == 'datetime'){
                                            $body .= '<input type="text" class="form-control" data-type="date" id="' . $table_name . '_field_' . $title . '">' . "\n";
                                        }else{
                                            $body .= '<input type="text" class="form-control" data-type="string" id="' . $table_name . '_field_' . $title . '">' . "\n";
                                        }
                                    $body .= '</div>' . "\n";
                                $body .= '</div>' . "\n";
                            }
                        $body .= '</div>' . "\n";
                    $body .= '</form>' . "\n";

                    $body .= '<div class="modal-footer">' . "\n";
                        $body .= '<input type="hidden" id="data-id" value="-1"/>' . "\n";
                        $body .= '<button type="button" class="btn btn-primary" id="save_record">Save</button>' . "\n";
                        $body .= '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>' . "\n";
                    $body .= '</div>' . "\n";
                $body .= '</div>' . "\n";
            $body .= '</div>' . "\n";
        $body .= '</div>' . "\n";

        $html = $header.$body;
        return $html;
    }

    function generate_content_javascript($data, $flag = true ){
        $endln = $flag ? "\n" : "";
        $tab = $flag ? "\t" : "";

        $table_name = $data["table_name"];
        $primary_key = $data["primary_key"];
        $columns = $data["columns"];

        $js = 'base_url = "/plugins/' . PLUGIN_PATH . '/interfaces/php/' . $table_name . '.php";';
        $js .= $endln . 'var table;';
        $js .= $endln . 'var sel_tr;';
        $js .= $endln . '$(document).ready(function(){';
            $js .= $endln . $tab . 'init_table();';
            $js .= $endln . $tab . '$("#' . $table_name . '_new").on("click", new_record);';
            $js .= $endln . $tab . '$("#' . $table_name . '_body").on("click", ".edit-item", edit_record );';
            $js .= $endln . $tab . '$("#' . $table_name . '_body").on("click", ".delete-item", delete_record );';
            $js .= $endln . $tab . '$("#save_record").on("click", save_record );';
        $js .= $endln . '});';

        $js .= $endln . 'function save_record(){';
            $js .= $endln . $tab . 'var id = $("#data-id").val();';
            foreach($columns as $col ){
                extract($col );
                $js .= $endln . $tab . 'var tr_' . $title . ' = $("#' . $table_name . '_field_' . $title . '").val()';
            }
            $js .= $endln . $tab . '$.ajax({';
                $js .= $endln . $tab . $tab . 'url: base_url,';
                $js .= $endln . $tab . $tab . 'data:{';
                    $js .= $endln . $tab . $tab . $tab . 'type: "save",';
                    $js .= $endln . $tab . $tab . $tab . 'id: id,';
                    foreach($columns as $col ){
                        extract($col );
                        $js .= $endln . $tab . $tab . $tab . $title . ': tr_' . $title . ",";
                    }
                $js .= $endln . $tab . $tab . '},';
                $js .= $endln . $tab . $tab . 'type: "post",';
                $js .= $endln . $tab . $tab . 'dataType: "json",';
                $js .= $endln . $tab . $tab . 'success: function(data){';
                    $js .= $endln . $tab . $tab . $tab . 'if (data["status"] == "success" ){';
                        $js .= $endln . $tab . $tab . $tab . $tab . 'if (id == "-1"){';
                            $js .= $endln . $tab . $tab . $tab . $tab . $tab . 'var table_id = data["insert_id"];';
                            $js .= $endln . $tab . $tab . $tab . $tab . $tab . 'table.row.add( [';
                            foreach($columns as $col ){
                                extract($col );
                                $js .= 'tr_' . $title . ', ';
                            }
                            $js .= "'" . '<button class="btn btn-xs btn-sm btn-primary mr-6 edit-item" data-id="' .
                            "table_id" . '"><i class="fa fa-edit"></i></button><button class="btn btn-xs btn-sm btn-secondary delete-item" data-id"' . "table_id" . '"><i class="fa fa-trash"></i></button>' . "'" . ']).draw( false );';
                        $js .= $endln . $tab . $tab . $tab . $tab . '}else{';
                            foreach($columns as $col ){
                                extract($col );
                                $js .= $endln . $tab . $tab . $tab . $tab . $tab . '$("#' . $table_name . '_table tr.selected").find(".' . $table_name. '_td_' . $title . '").text(tr_' . $title . ' );';
                            }
                        $js .= $endln . $tab . $tab . $tab . $tab . '}';
                        $js .= $endln . $tab . $tab . $tab . $tab . '$("#edit-modal").modal("hide");';
                    $js .= $endln . $tab . $tab . $tab . '}';
                $js .= $endln . $tab . $tab . '}';

            $js .= $endln . $tab . '});';
        $js .= $endln . '}';

        $js .= $endln . 'function new_record(){';
            $js .= $endln . $tab . '$("#data-id").val("-1");';
            $js .= $endln . $tab . '$("#edit-modal").modal("show");';
        $js .= $endln . '}';

        $js .= $endln . 'function delete_record(){';
            $js .= $endln . $tab . 'var id = $(this).attr("data-id");';
            $js .= $endln . $tab . 'sel_tr = $(this).parent().parent();';
            $js .= $endln . $tab . 'if (confirm("Are you going to delete this record?")){';
                $js .= $endln . $tab . $tab . '$.ajax({';
                    $js .= $endln . $tab . $tab . $tab . 'url: base_url,';
                    $js .= $endln . $tab . $tab . $tab . 'data:{';
                        $js .= $endln . $tab . $tab . $tab . $tab . "type: 'delete',";
                        $js .= $endln . $tab . $tab . $tab . $tab . "id: id";
                    $js .= $endln . $tab . $tab . $tab . '},';
                    $js .= $endln . $tab . $tab . $tab . 'type:"post",';
                    $js .= $endln . $tab . $tab . $tab . 'dataType: "json",';
                    $js .= $endln . $tab . $tab . $tab . 'success: function(data){';
                        $js .= $endln . $tab . $tab . $tab . $tab . 'if (data["status"] == "success"){';
                            $js .= $endln . $tab . $tab . $tab . $tab . $tab . "table.row('.selected').remove().draw( false );";
                        $js .= $endln . $tab . $tab . $tab . $tab . '}';
                    $js .= $endln . $tab.  $tab . $tab . '}';
                $js .= $endln . $tab . $tab . '})';
            $js .= $endln . $tab . '}';
        $js .= $endln . '}';

        $js .= $endln . 'function edit_record(){';
            $js .= $endln . $tab . "var id = $(this).attr('data-id');";
            $js .= $endln . $tab . "sel_tr = $(this).parent().parent();";
            $js .= $endln . $tab . '$("#data-id").val(id );';
            foreach($columns as $col ){
                extract($col );
                $js .= $endln . $tab . $tab . '$("#' . $table_name . '_field_' . $title . '").val($(sel_tr).find(".' . $table_name . '_td_' . $title . '").text());';
            }
            $js .= '$("#edit-modal").modal("show");';
        $js .= $endln . '}';

        $js .= $endln . 'function init_table(){';
            $js .= $endln . $tab . '$.ajax({';
                $js .= $endln . $tab . $tab . 'url: base_url,';
                $js .= $endln . $tab . $tab . 'data:{';
                    $js .= $endln . $tab . $tab . $tab . 'type: "init_table"';
                $js .= $endln . $tab . $tab . '},';
                $js .= $endln . $tab . $tab . 'dataType: "json",';
                $js .= $endln . $tab . $tab . 'type: "post",';
                $js .= $endln . $tab . $tab . 'success: function(data ){';
                    $js .= $endln . $tab . $tab . $tab . 'if (data["status"] == "success" ){';
                        $js .= $endln . $tab . $tab . $tab . $tab . 'load_data(data["data"]);';
                    $js .= $endln . $tab . $tab . $tab . '}';
                $js .= $endln . $tab . $tab . '}';
            $js .= $endln . $tab . '});';
        $js .= $endln . '}';

        $js .= $endln . 'function load_data(data ){';
            $js .= $endln . $tab . 'var parent = $("#' . $table_name . '_body");';
            $js .= $endln . $tab . 'for(var i = 0; i < data.length; i++ ){';
                $js .= $endln . $tab . $tab . 'var item = data[i];';
                $js .= $endln . $tab . $tab . "var tr = $('<tr>').attr('data-id', item[0]).appendTo(parent );";
                foreach($columns as $key=> $col ){
                    extract($col );
                    $js .= $endln . $tab . $tab . $tab . '$("<td>").text(item[' . ($key + 1) . ']).addClass("' . $table_name . '_td_' . $title . '").appendTo(tr);';
                }
                $js .= $endln . $tab . $tab . 'var td = $("<td>").appendTo(tr );';
                $js .= $endln . $tab . $tab . '$("<button>").addClass("btn btn-xs btn-sm btn-primary mr-6 edit-item")';
                            $js .= $endln . $tab . $tab.  $tab . '.attr("data-id", item[0])';
                            $js .= $endln . $tab . $tab.  $tab . '.html("<i class=' . "'fa fa-edit'" . '></i>").appendTo(td );';
                $js .= $endln . $tab . $tab . '$("<button>").addClass("btn btn-xs btn-sm btn-secondary delete-item")';
                            $js .= $endln . $tab . $tab.  $tab . '.attr("data-id", item[0])';
                            $js .= $endln . $tab . $tab.  $tab . '.html("<i class=' . "'fa fa-trash'" . '></i>").appendTo(td );';
            $js .= $endln . $tab . '}';
            $js .= $endln . $tab . 'table = $("#' . $table_name . '_table").DataTable();';
        
            $js .= $endln . $tab . "$('#" . $table_name . "_table tbody').on( 'click', 'tr', function () {";
                $js .= $endln . $tab . $tab . "if ( $(this).hasClass('selected') ) {";
                    $js .= $endln . $tab . $tab . $tab . "$(this).removeClass('selected');";
                $js .= $endln . $tab . $tab . "}";
                $js .= $endln . $tab . $tab . "else {";
                    $js .= $endln . $tab . $tab . "table.$('tr.selected').removeClass('selected');";
                    $js .= $endln . $tab . $tab . "$(this).addClass('selected');";
                $js .= $endln . $tab . $tab . "}";
            $js .= $endln . $tab . "});";
        $js .= $endln . "}"; 
        return $js;
    }

    function generate_content_php($data, $flag = true ){
        $endln = $flag ? "\n" : "";
        $tab = $flag ? "\t" : "";

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
            $php .= $endln . $tab .  'include_once("../../../../config/config.php");';
            $php .= $endln . $tab .  'include_once("./' . $table_name . '_sql.php");';
            $php .= "include_once '../../../../config/database.php';";
            $php .= '$db = new Database();';
            $php .= '$db->getConnection(API_DB_NAME );';
            //$php .= $endln . $tab .  'include_once("../db.php");';
            //$php .= $endln . $tab .  '$db = new dbObj();';
            $php .= $endln . $tab .  'extract($_POST);';
            $php .= $endln . $tab .  'switch($type ){';
                $php .= $endln . $tab .  $tab . 'case "init_table":';
                    $php .= $endln . $tab .  $tab . $tab . 'init_table();';
                    $php .= $endln . $tab .  $tab . $tab . 'break;';
                $php .= $endln . $tab. $tab .  'case "delete":';
                    $php .= $endln . $tab .  $tab . $tab . 'delete_tr($id);';
                    $php .= $endln . $tab .  $tab . $tab . 'break;';
                $php .= $endln . $tab. $tab .  'case "save":';
                    $php .= $endln . $tab .  $tab .  $tab .  'save_tr($id ';
                        foreach($columns as $col ){
                            extract($col );
                            $php .= ",$" . $title;
                        }
                    $php .= ');';
                    $php .= $endln . $tab. $tab .  $tab . 'break;';
            $php .= $endln . $tab . '}';
            
            $php .= $endln . 'function init_table(){';
                $php .= $endln . $tab . '$query = $GLOBALS["query"];';
                $php .= $endln . $tab . '$db = $GLOBALS["db"];';
                //$php .= $endln . $tab . '$db->run_query($query );';
                $php .= $endln . $tab . '$result = $db->load_data("' . $table_name . '");';
        
                $php .= $endln . $tab . '$data = [];';
                $php .= $endln . $tab . 'if($result){';
                    $php .= $endln . $tab . $tab . 'while ($row = $result->fetch(PDO::FETCH_BOTH)){';
                        $php .= $endln . $tab . $tab . $tab . '$item = [];';
                        $php .= $endln . $tab . $tab . $tab . 'array_push($item, $row["id"]);';
                        foreach($columns as $col ){
                            extract($col );
                            $php .= $endln . $tab . $tab . $tab . 'array_push($item, $row["' . $title . '"]);';
                        }
                        $php .= $endln . $tab . $tab . $tab . 'array_push($data, $item );';
                    $php .= $endln . $tab . $tab . '}';
                $php .= $endln . $tab . '}';
                $php .= $endln . $tab . 'echo json_encode(["status"=>"success", "data"=> $data ]);';
            $php .= $endln . '}';

            $php .= $endln . 'function delete_tr($id ){';
                $php .= $endln . $tab . '$query = "delete from ' . $table_name . ' where ' . $primary_key . '={$id}";';
                $php .= $endln . $tab . '$db = $GLOBALS["db"];';
                $php .= $endln . $tab . '$db->run_query($query );';
                $php .= $endln . $tab . 'echo json_encode(["status"=> "success"]);';
            $php .= $endln . '}';

            $php .= $endln . 'function save_tr($id, ' . $tmp_key . '){';
                $php .= $endln . $tab . '$db = $GLOBALS["db"];';
                $php .= $endln . $tab . 'if ($id == "-1"){';
                    $php .= $endln . $tab . $tab . '$query = "insert into ' . $table_name . ' set ' . $tmp . '";';
                $php .= $endln . $tab . '}else{';
                    $php .= $endln . $tab . $tab . '$query = "update ' . $table_name . ' set ' . $tmp . ' where ' . $primary_key . '={$id}";';
                $php .= $endln . $tab . '}';
                $php .= $endln . $tab . '$id = $db->update_query($query );';
                $php .= $endln . $tab . 'echo json_encode(["status"=> "success", "' . $primary_key . '"=> $id ]);';
            $php .= $endln . '}';

        $php .= $endln . "?>";
        return $php;
    }
?>