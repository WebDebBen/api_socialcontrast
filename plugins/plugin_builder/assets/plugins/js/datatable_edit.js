var dtn_table_name = "";
$(document).ready(function(){
    init_dtn_datatable_list();
    init_dtn_table_view_list();
    $("#dt_datatable_load").on("click", load_dtn_datatable_data );
    $("#dt_datatable_preview").on("click", load_dtn_datatable_preview );
    $("#dt_table_view_load").on("click", load_dtn_table_view_data);
    $("#dt_columns_list").on("click", ".remove-table-prop-item", remove_dtn_table_column );
    $("#add_dtn_new_column").on("click", add_dtn_new_column);
    $("#dtn_datatable_save_btn").on("click", save_dtn_datatable_data);
});

function save_dtn_datatable_data(){
    var dtn_datatable_name = $("#dtn_datatable_name").val();
    var json_data = get_dtn_jsondata(dtn_datatable_name);
    if (json_data["status"] == false ){
        toastr.error(json_data["error"]);
        return;
    }

    $.ajax({
        url: "/plugins/" + plugin_name + "/include/classes/plugin_datatable_edit.php",
        data: {
            type: "save_datatable_data",
            datatable_name: dtn_datatable_name,
            table_name: $("#dtn_table_view_origin_name").val(),
            json_data: json_data,
            plugin_name: $("#plugin_name").val()
        },
        type: "post",
        dataType: "json",
        success: function(res ){
            toastr.success("success");
            init_dtn_datatable_list();
        }
    });
}

function add_dtn_new_column(){
    var parent = $("#dt_columns_list");
    var template = $("#dtn-datatb_table-prop-item-template .table-prop-item").clone();
    $(template).appendTo($(parent));
}

function remove_dtn_table_column(){
    $(this).parent().parent().parent().parent().remove();
}

function init_dtn_datatable_list(){
    $.ajax({
        url: "/plugins/" + plugin_name + "/include/classes/plugin_datatable_edit.php",
        data: {
            type: "datatable_list",
            plugin_name: $("#plugin_name").val()
        },
        type: "post",
        dataType: "json",
        success: function(res ){
            var parent = $("#dt_datatable_list");
            $(parent).html("");
            for (var i = 0; i < res.length; i++){
                var item = res[i];
                $("<option>").attr("value", item).text(item).appendTo(parent);
            }
        }
    });
}

function init_dtn_table_view_list(){
    $.ajax({
        url: "/plugins/" + plugin_name + "/include/classes/plugin_datatable_edit.php",
        data: {
            type: "table_view_list",
            plugin_name: $("#plugin_name").val()
        },
        type: "post",
        dataType: "json",
        success: function(res ){
            var parent = $("#dt_table_view_list");
            $(parent).html("");
            for (var i = 0; i < res.length; i++){
                var item = res[i];
                $("<option>").attr("value", item[0]["value"]).text(item[0]["value"]).appendTo(parent);
            }
        }
    });
}

function load_dtn_datatable_data(){
    var table_name = $("#dt_datatable_list").val();
    $.ajax({
        url: "/plugins/" + plugin_name + "/include/classes/plugin_datatable_edit.php",
        data: {
            type: "datatable_columns",
            table_name: table_name,
            plugin_name: $("#plugin_name").val()
        },
        type: "post",
        dataType: "json",
        success: function(res ){
            var table_info = res;
            var content = table_info["content"];
            content = $.parseJSON(content);
            $("#dtn_table_view_origin_name").val(content["table_name"]);
            dtn_table_name = table_name;
            
            var columns = content["columns"];
            var parent = $("#dt_columns_list");
            $(parent).html("");
            del_items = [];
            for (var i = 0;i < columns.length; i++){
                var item = columns[i];
                var column_name = item["column_name"];
                if (column_name == "created_id" || column_name == "created_at" || column_name == "updated_id" || column_name == "updated_at") continue;
                
                var data_type = item["data_type"];
                var column_type = item["column_type"];
                var ref_table = item["referenced_table_name"] ? item["referenced_table_name"] : "";
                var ref_field = item["referenced_column_name"] ? item["referenced_column_name"] : "";
                var default_value = item["column_default"];
                column_type = column_type == "varchar" ? "varchar(255)" : column_type;
                column_type = data_type == "tinyint" ? data_type : column_type;
                var visible = item["visible"] ? item["visible"] : "true";
                var show_search = item["show_search"] ? item["show_search"] : "true";

                var template = $("#dtn-datatb_table-prop-item-template .table-prop-item").clone();
                $(template).find(".field-title-input").val(column_name);
                $(template).find(".field-type-input").val(column_type);
                $(template).find(".field-default-value-input").val(default_value );
                $(template).find(".field-props-wrap").attr("data-table", ref_table );
                $(template).find(".field-props-wrap").attr("data-field", ref_field );
                $(template).find(".field-props-wrap").attr("data-type", data_type); 
                $(template).attr("data-column", column_name);
                $(template).attr("data-columntype", column_type);
                if (visible != "true"){
                    $(template).find(".field-visible-table-input").removeAttr("checked");
                }
                if (show_search != "true"){
                    $(template).find(".field-show-advanced-search-input").removeAttr("checked");
                }
                $(template).appendTo($(parent));

            }
        }
    });
}

function load_dtn_datatable_preview(){

}

function load_dtn_table_view_data(){
    var table_name = $("#dt_table_view_list").val();
    $("#dtn_table_view_origin_name").val(table_name)
    $.ajax({
        url: "/plugins/" + plugin_name + "/include/classes/plugin_datatable_edit.php",
        data: {
            type: "table_view_columns",
            table_name: table_name
        },
        type: "post",
        dataType: "json",
        success: function(res ){
            var table_info = res;
            var columns = table_info["columns"];
            var parent = $("#dt_columns_list");
            $(parent).html("");
            del_items = [];
            for (var i = 0;i < columns.length; i++){
                var item = columns[i];
                var column_name = item["column_name"];
                if (column_name == "created_id" || column_name == "created_at" || column_name == "updated_id" || column_name == "updated_at") continue;
                
                var data_type = item["data_type"];
                var column_type = item["column_type"];
                var ref_table = item["referenced_table_name"] ? item["referenced_table_name"] : "";
                var ref_field = item["referenced_column_name"] ? item["referenced_column_name"] : "";
                var default_value = item["column_default"];
                column_type = column_type == "varchar" ? "varchar(255)" : column_type;
                column_type = data_type == "tinyint" ? data_type : column_type;
                var visible = item["visible"] ? item["visible"] : "true";
                var show_search = item["show_search"] ? item["show_search"] : "true";

                var template = $("#dtn-datatb_table-prop-item-template .table-prop-item").clone();
                $(template).find(".field-title-input").val(column_name);
                $(template).find(".field-type-input").val(column_type);
                $(template).find(".field-default-value-input").val(default_value );
                $(template).find(".field-props-wrap").attr("data-table", ref_table );
                $(template).find(".field-props-wrap").attr("data-field", ref_field );
                $(template).find(".field-props-wrap").attr("data-type", data_type); 
                $(template).attr("data-column", column_name);
                $(template).attr("data-columntype", column_type);
                if (visible != "true"){
                    $(template).find(".field-visible-table-input").removeAttr("checked");
                }
                if (show_search != "true"){
                    $(template).find(".field-show-advanced-search-input").removeAttr("checked");
                }
                $(template).appendTo($(parent));

            }
        }
    });
}

function dtp_edit_table_new(){
    $("#data-dtp-id").val("");
    $(".dtp-edit-input").val("");
    $("#dtp-edit-modal").modal("show");
}

function get_dtn_jsondata(datatable_name){
    var columns = []; 
    var cols = $("#dt_columns_list .table-prop-item");
    for(var i = 0;i < cols.length; i++ ){
        var col = cols[i];
        var title = $(col).find(".field-title-input").val();
        var type = $(col).find(".field-type-input").val();
        var data_type = $(col).find(".field-type-input option:selected").attr("data-type");
        var default_value = $(col).find(".field-default-value-input").val();
        var show_table = $(col ).find(".field-visible-table-input").is(":checked");
        var editor_table = $(col).find(".field-show-advanced-search-input").is(":checked");

        if (title == "" ){
            return {"status": false, "error": "Title is required"};
        }else if (!validate_name(title )){
            return {"status": false, "error": "Title only can be letter and number"};
        }

        columns.push({
            column_name: title,
            column_type: type,
            data_type: data_type,
            column_default: default_value,
            visible: show_table ? "true" : "false",
            show_search: editor_table ? "true" : "false"
        });
    }

    return {
        "status": true,
        table_name: datatable_name,
        columns: columns
    }
}