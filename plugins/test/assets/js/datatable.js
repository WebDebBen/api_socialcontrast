var sel_item = null;
var sel_table = "new";

$(document).ready(function(){
    new Sortable(document.getElementById("table-property"), {
        handle: '.fa-arrows-alt',
        animation: 150,
        ghostClass: 'blue-background-class'
    });

    $("#add-table-prop-item-btn").on("click", add_column_block );
    $("#table-property").on("click", ".remove-table-prop-item", function(e){
        $(this).parent().parent().parent().parent().remove();
    });

    $("#table-property").on("click", ".add-props-edit", function(e){
        edit_field_config(this );
    });

    $("#save_config").on("click", save_config );
    $("#gen_sql").on("click", generate_sql );
    $("#gen_html").on("click", generate_html );
    $("#gen_javascript").on("click", generate_javascript );
    $("#gen_php").on("click", generate_php );
    $("#gen_json").on("click", generate_json );
    $("#run_btn").on("click", run_obj );
    $("#save_btn").on("click", save_obj );
    $("#check_table").on("click", select_table_name );
    $("#select_table").on("click", select_table );
    $("#table-list-md").on("change", dispaly_table_fields );

    add_column_block();
    add_column_block();

    init_table_list();
});


function dispaly_table_fields(){
    $.ajax({
        url: "/plugins/plugin_builder/include/classes/table_generate.php",
        data: {
            type: "table_info",
            table: $(this).val()
        },
        type: "post",
        dataType: "json",
        success: function(res ){
            var columns = res["columns"];
            $(".ref_field_item").remove();
            for (var i = 0;i < columns.length; i++){
                var item = columns[i];
                var column_name = item["column_name"];
                var column_type = item["column_type"];
                var data_type = item["data_type"];
                $("<option>").addClass("ref_field_item")
                        .attr("value", column_name).text(column_name + ":" + column_type)
                        .attr("column-type", column_type)
                        .attr("data-type", data_type)
                        .appendTo($("#field-list-md"));
            }
        }
    });
}

function select_table(){
    $.ajax({
        url: "/plugins/plugin_builder/include/classes/table_generate.php",
        data: {
            type: "table_info",
            table: $("#table_list_sel").val()
        },
        type: "post",
        dataType: "json",
        success: function(res ){
            $("#table-name-input").val(res["table_name"]);
            var columns = res["columns"];

            var parent = $("#table-property");
            $(parent).html("");
            for (var i = 0;i < columns.length; i++){
                var item = columns[i];
                var max_length = item["character_maximum_length"];
                var column_name = item["column_name"];
                var data_type = item["data_type"];
                var column_key = item["column_key"];
                var column_type = item["column_type"] 
                var ref_table = item["referenced_table_name"];
                var ref_field = item["referenced_column_name"];
                if (column_key == "PRI"){
                    $("#primary-key-input").val(column_name);
                }else{
                    var template = $("#table-prop-item-template .table-prop-item").clone(); 
                    $(template).find(".field-title-input").val(column_name);
                    $(template).find(".field-type-input").val(column_type);
                    $(template).find(".field-default-value-input").val(item["column_default"]);
                    $(template).find(".field-props-wrap").attr("data-table", ref_table );
                    $(template).find(".field-props-wrap").attr("data-field", ref_field );
                    $(template).find(".field-props-wrap").attr("data-type", data_type); 
                    $(template).find(".reference_table_span").text(ref_table ? ref_table : "None" );
                    $(template).find(".reference_field_span").text(ref_field ? ref_field : "None" );
                    $(template).appendTo($(parent));
                }
            }
        }
    });
}

function init_table_list(){ 
    $.ajax({
        url: "/plugins/plugin_builder/include/classes/table_generate.php",
        data: {
            type: "table_list"
        },
        type: "post",
        dataType: "json",
        success: function(res ){
            var all = res["all"];
            $(".ref_table_item").remove();
            for(var i = 0; i < all.length; i++ ){
                var item = all[i];
                $("<option value='" + item + "'>").addClass("ref_table_item").text(item).appendTo($("#table-list-md"));
            }

            var made = res["made"];
            $("#table_list_sel").html("");
            for(var i = 0; i < made.length; i++ ){
                $("<option>").attr("value", made[i]).text(made[i]).appendTo($("#table_list_sel"));
            }
        }
    });
}

function select_table_name(){
    var table_name = $("#table_list_sel").val();
    window.open("/admin/plugins/plugin_product_catalog/" + table_name, "_blank");
}

function run_obj(){
    generate_content("run" );
}

function save_obj(){
    generate_content("save");
}

function formatHTML(html) {
    var indent = '\n';
    var tab = '\t';
    var i = 0;
    var pre = [];

    html = html
        .replace(new RegExp('<pre>((.|\\t|\\n|\\r)+)?</pre>'), function (x) {
            pre.push({ indent: '', tag: x });
            return '<--TEMPPRE' + i++ + '/-->'
        })
        .replace(new RegExp('<[^<>]+>[^<]?', 'g'), function (x) {
            var ret;
            var tag = /<\/?([^\s/>]+)/.exec(x)[1];
            var p = new RegExp('<--TEMPPRE(\\d+)/-->').exec(x);

            if (p) 
                pre[p[1]].indent = indent;

            if (['area', 'base', 'br', 'col', 'command', 'embed', 'hr', 'img', 'input', 'keygen', 'link', 'menuitem', 'meta', 'param', 'source', 'track', 'wbr'].indexOf(tag) >= 0) // self closing tag
                ret = indent + x;
            else {
                if (x.indexOf('</') < 0) { //open tag
                    if (x.charAt(x.length - 1) !== '>')
                        ret = indent + x.substr(0, x.length - 1) + indent + tab + x.substr(x.length - 1, x.length);
                    else 
                        ret = indent + x;
                    !p && (indent += tab);
                }
                else {//close tag
                    indent = indent.substr(0, indent.length - 1);
                    if (x.charAt(x.length - 1) !== '>')
                        ret =  indent + x.substr(0, x.length - 1) + indent + x.substr(x.length - 1, x.length);
                    else
                        ret = indent + x;
                }
            }
            return ret;
        });

    for (i = pre.length; i--;) {
        html = html.replace('<--TEMPPRE' + i + '/-->', pre[i].tag.replace('<pre>', '<pre>\n').replace('</pre>', pre[i].indent + '</pre>'));
    }

    return html.charAt(0) === '\n' ? html.substr(1, html.length - 1) : html;
}

function generate_content(type ){
    var json_data = get_jsondata();
    if (json_data["status"] == false ){
        toastr.error(json_data["error"]);
    }

    $.ajax({
        url: "/plugins/plugin_builder/include/classes/table_generate.php",
        data: {
            json_data: json_data["data"],
            type: type
        },
        type: "post",
        dataType: "json",
        success: function(res ){
            if (res["status"] == "success" ){
                if (type == "run" ){
                    window.open( "/admin/plugins/" + $("#plugin_path").val() + "/" + res["data"], "_blank");
                }else if(type == "save"){
                    toastr.success("successfuly saved!");
                    $("<option>").attr("value", res["data"]).text(res["data"]).appendTo($("#table_list_sel"));
                }else{
                    $("#generated_content").html("");
                    var pre = $("<pre>").addClass("code").appendTo($("#generated_content"));
                    if (type == 'html'){
                        $(pre).text(formatHTML(res["data"]));
                    }else if(type == 'json'){
                        $(pre).html(JSON.stringify(json_data["data"], null, "\t"));
                    }else{
                        $(pre).text(res["data"]);
                    }
                    $('pre.code').highlight({source:1, zebra:1, indent:'space', list:'ol'});
                    $("#generated-modal .modal-title").html("Generated " + type.toUpperCase());
                    $("#generated-modal").modal("show");
                }
            }else if(res["status"] == "duplicated"){
                alert("table is duplicated");
            }
        }
    })
}

function generate_json(){
    generate_content("json");
}

function generate_sql(){
    generate_content("sql" );
}

function generate_html(){
    generate_content("html" );
}

function generate_javascript(){
    generate_content("javascript" );
}

function generate_php(){
    generate_content("php" );
}

function save_config(){
    var title = $("#field-title-md").val();
    var type = $("#field-type-md").val();
    var data_type = $("#field-type-md option:selected").attr("data-type");
    var required = $("#required_yes").is(":checked");
    var default_value = $("#field-default-value-md").val();
    var show_table = $("#table_yes").is(":checked");
    var editor_table = $("#editor_yes").is(":checked");
    var ref_table = $("#table-list-md").val();
    var ref_field = $("#field-list-md").val();
    var ref_field_type = $("#field-list-md option:selected").attr("data-type");
    if (ref_field == "") ref_table = "";

    if (ref_field_type != data_type ){
        toastr.error("The field type of reference table must match with the field type of current table");
        return;
    }

    $(sel_item).find(".field-title-input").val(title )
    $(sel_item).attr("data-columnname", title );
    $(sel_item).find(".field-default-value-input").val(default_value );
    $(sel_item).find(".field-required-input").prop("checked", required );
    $(sel_item).find(".field-show-table-input").prop("checked", show_table );
    $(sel_item).find(".field-show-editor-input").prop("checked", editor_table );
    $(sel_item).find(".field-type-input").val(type);
    $(sel_item).attr("data-table", ref_table ).attr("data-field", ref_field).attr("data-type", ref_field_type);
    $(sel_item).find(".reference_table_span").text(ref_table == "" ? "NONE" : ref_table );
    $(sel_item).find(".reference_field_span").text(ref_field == "" ? "NONE" : ref_field );

    $("#column-detail-modal").modal("hide");
}

function edit_field_config(obj ){
    var parent = $(obj ).parent().parent();//.find(".field-props");
    sel_item = parent;
    var title = $(parent).find(".field-title-input").val();
    var type = $(parent).find(".field-type-input").val();
    var requried = $(parent).find(".field-required-input").is(":checked");
    var default_value = $(parent).find(".field-default-value-input").val();
    var show_table = $(parent ).find(".field-show-table-input").is(":checked");
    var editor_table = $(parent).find(".field-show-editor-input").is(":checked");
    var ref_table = $(parent).attr("data-table");
    if (ref_table != "" ){
        $.ajax({
            url: "/plugins/plugin_builder/include/classes/table_generate.php",
            data: {
                type: "table_info",
                table: ref_table
            },
            type: "post",
            dataType: "json",
            success: function(res ){
                var columns = res["columns"];
                $(".ref_field_item").remove();
                for (var i = 0;i < columns.length; i++){
                    var item = columns[i];
                    var column_name = item["column_name"];
                    var column_type = item["column_type"]
                    $("<option>").addClass("ref_field_item")
                            .attr("value", column_name).text(column_name + ":" + column_type)
                            .attr("data-type", column_type)
                            .appendTo($("#field-list-md"));
                }
                var ref_field = $(parent).attr("data-field");
                $("#field-list-md").val(ref_field);
            }
        });
    }
    
    
    $("#table-list-md").val(ref_table);
    

    $("#field-title-md").val(title );
    $("#field-column-name-md").val(title );
    $("#field-type-md").val(type );
    if (requried ){
        $("#required_yes").click();
    }else{
        $("#required_no").click();
    }
    $("#field-default-value-md").val(default_value );
    if(show_table){
        $("#table_yes").click();
    }else{
        $("#table_no").click();
    }
    if (editor_table ){
        $("#editor_yes").click();
    }else{
        $("#editor_no").click();
    }

    $("#column-detail-modal").modal("show");
}

function add_column_block(){
    var parent = $("#table-property");
    var template = $("#table-prop-item-template").html();
    $(parent).append(template );
}

function validate_name(str ){ 
    return !str.match(/[^a-zA-Z0-9_]/);
}

function get_jsondata(){
    var table_name = $("#table-name-input").val();
    var primary_key  =$("#primary-key-input").val();
    
    if (table_name == "" ){
        return {"status": false, "error": "Table is required"};
    }else if (!validate_name(table_name )){
        return {"status": false, "error": "Table name only can be letter and number"};
    }

    if (primary_key == "" ){
        return {"status": false, "error": "Primary key is required"};
    }else if (!validate_name(primary_key )){
        return {"status": false, "error": "Primary key only can be letter and number"};
    }

    var columns = [];
    var refs = [];
    var cols = $("#table-property .table-prop-item");
    for(var i = 0;i < cols.length; i++ ){
        var col = cols[i];
        var title = $(col).find(".field-title-input").val();
        var type = $(col).find(".field-type-input").val();
        var requried = $(col).find(".field-required-input").is(":checked");
        var default_value = $(col).find(".field-default-value-input").val();
        var show_table = $(col ).find(".field-show-table-input").is(":checked");
        var editor_table = $(col).find(".field-show-editor-input").is(":checked");
        var ref_obj = $(col ).find(".field-props-wrap");
        var ref_table = $(ref_obj).attr("data-table") ? $(ref_obj).attr("data-table") : "";
        var ref_field = $(ref_obj).attr("data-field") ? $(ref_obj).attr("data-field") : "";

        if (title == "" ){
            return {"status": false, "error": "Title is required"};
        }else if (!validate_name(title )){
            return {"status": false, "error": "Title only can be letter and number"};
        }

        if (ref_table != "" && ref_field != "" ){
            refs.push({field: title, ref_table: ref_table, ref_field: ref_field });
        }
        columns.push({
            title: title,
            type: type,
            requried: requried, 
            default_value: default_value,
            show_table: show_table,
            editor_table: editor_table,
            ref_table: ref_table,
            ref_field: ref_field
        })
    }

    return {
        "status": true,
        data: {
            table_name: table_name.toLowerCase(),
            primary_key: primary_key,
            columns: columns,
            refs: refs
        }
    }
}