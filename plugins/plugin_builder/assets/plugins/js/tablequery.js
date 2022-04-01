var tq_editor;
var tq_query_json = {
    query: "",
    table: "",
    columns: "",
    joins: {
    }
};

$(document).ready(function(){
    $("#run_tq_query").on("click", function(e){
        $.ajax({
            url: "/plugins/" + plugin_name + "/include/classes/plugin_tablequery.php",
            data: {
                type: "run_query",
                query: $("#tablequery_code_area").val()
            },
            type: "post",
            dataType: "json",
            success: function(res){
                display_tq_data(res);
            }
        });
    });

    $("#tq_save_query").on("click", function(e){
        var query_name = $("#tq_query_name").val();
        if (query_name == ""){
            toastr.error("Please input the Query Name");
            return;
        }
        var plugin_name = $("#plugin_name").val();
        $.ajax({
            url: "/plugins/" + plugin_name + "/include/classes/plugin_tablequery.php",
            data: {
                type: "save_query",
                query_name: query_name,
                plugin_name: $("#plugin_name").val(),
                query: $("#tablequery_code_area").val()
            },
            type: "post",
            dataType: "json",
            success: function(res){
                var parent = $("#tablequery-wrap");
                $(parent).html("");
                if (res["status"] == "error"){
                    toastr.error(res["result"][2]);
                }else{
                    tq_make_rest_api($("#plugin_name").val(), query_name );   
                }
            }
        });
    });

    $("#load_tq_query").on("click", function(){
        var query_name = $("#tq_query_list").val();
        if (query_name == ""){
            toastr.error("Please input the Query Name");
            return;
        }
        var plugin_name = $("#plugin_name").val();
        $.ajax({
            url: "/plugins/" + plugin_name + "/include/classes/plugin_tablequery.php",
            data: {
                type: "load_query",
                query_name: query_name,
                plugin_name: $("#plugin_name").val()
            },
            type: "post",
            dataType: "json",
            success: function(res){
                $("#tablequery_code_area").val(res["data"]);
            }
        });
    });

    $("#tq_table_list").on("change", init_tq_column_list);
    $("#add_table_tq_query").on("click", add_table_tq_query );
    $("#add_column_tq_query").on("click", add_column_tq_query );
    init_tq_query_list();
    init_tq_table_list();
});

function tq_make_rest_api(plugin_name, query_name ){
    $.ajax({
        url: "/plugins/" + plugin_name + "/include/classes/plugin_generate.php",
        data: {
            type: "query_api",
            plugin_name: $("#plugin_name").val(),
            query_name: query_name
        },
        type: "post",
        dataType: "json",
        success: function(data ){ 
            if (data["status"] == "success"){
                var filename = data["data"]["apidoc"];
                toastr.success("Successfully generated");
                $("#reapi_doc_tq").html("<a target='_blank' href='/plugins/" + $("#plugin_name").val() + "/api/documentation/" + filename + "'>" + filename + "</a>");
                init_tq_query_list();
            }else{
                toastr.error("failed to generated API");
            }
        }
    });

}

function add_table_tq_query(){
    var table_name = $("#tq_table_list").val();
    var curPos = document.getElementById("tablequery_code_area").selectionStart;
    let x = $("#tablequery_code_area").val();
    $("#tablequery_code_area").val(
        x.slice(0, curPos) + table_name + x.slice(curPos));
}

function add_column_tq_query(){
    var column_list = $("#tq_column_list").val();
    var str = "";
    var comma = " ";
    for(var i = 0; i < column_list.length; i++ ){
        str = str + comma + column_list[i];
        comma = ",";
    }
    var curPos = document.getElementById("tablequery_code_area").selectionStart;
    let x = $("#tablequery_code_area").val();
    $("#tablequery_code_area").val(
        x.slice(0, curPos) + str + x.slice(curPos));
}

function init_tq_table_list(){
    var plugin_name = $("#plugin_name").val();
    $.ajax({
        url: "/plugins/" + plugin_name + "/include/classes/plugin_tablequery.php",
        data: {
            type: "load_table_list",
            plugin_name: $("#plugin_name").val(),
        },
        type: "post",
        dataType: "json",
        success: function(res){
            res = res["data"];
            var select = $("#tq_table_list");
            $(select).html("");
            for (var i = 0; i < res.length; i++){
                $("<option>").attr("val", res[i]).text(res[i]).appendTo(select);
            }
            init_tq_column_list();
        }
    }); 
}

function init_tq_column_list(){
    var table_name = $("#tq_table_list").val();
    var plugin_name = $("#plugin_name").val();
    $.ajax({
        url: "/plugins/" + plugin_name + "/include/classes/plugin_tablequery.php",
        data: {
            type: "load_column_list",
            table_name: table_name
        },
        type: "post",
        dataType: "json",
        success: function(res){
            res = res["data"];
            var select = $("#tq_column_list");
            $(select).html("");
            var columns = res["columns"];
            for (var i = 0; i < columns.length; i++){
                var item = columns[i];
                var column_name = item["column_name"];
                if (column_name != "created_at" && column_name != "created_id" && column_name != "updated_at" && column_name != "updated_id" ){ 
                    $("<option>").attr("val", column_name).text(column_name).appendTo(select);
                }
            }

            //$("#tq_column_list + .btn-group").remove();
            if ($(".multiselect-container").length > 0){
                $("#tq_column_list").parent().parent().html($("#tq_column_list").clone())
            }
            $('#tq_column_list').multiselect({
                enableClickableOptGroups: true,
                includeSelectAllOption:true,
                nonSelectedText: 'Select language'
            });
        }
    }); 
}

function init_tq_query_list(){
    var plugin_name = $("#plugin_name").val();
    $.ajax({
        url: "/plugins/" + plugin_name + "/include/classes/plugin_tablequery.php",
        data: {
            type: "load_query_list",
            plugin_name: $("#plugin_name").val(),
        },
        type: "post",
        dataType: "json",
        success: function(res){
            var select = $("#tq_query_list");
            $(select).html("");
            for (var i = 0; i < res.length; i++){
                $("<option>").attr("val", res[i]).text(res[i]).appendTo(select);
            }
        }
    });
}

function display_tq_data(res){
    var parent = $("#tablequery-wrap");
    $(parent).html("");

    var result = res["result"];
    if (res["status"] == "error"){
        //$("<p>").html(result[2]).appendTo(parent);
        toastr.error(result[2]);
    }else{
        var table = $("<table>").addClass("table").appendTo(parent);
        var thead = $("<thead>").appendTo(table);
        var tbody = $("<tbody>").appendTo(table);
        for (var i = 0; i < result.length; i++){
            var item = result[i];
            if (i == 0){
                var tr = $("<tr>").appendTo(thead);
                for (var j = 0; j < item.length; j++){
                    $("<th>").html(item[j]["key"]).appendTo(tr);
                }
            }
            var tr = $("<tr>").appendTo(tbody);
            for (var j = 0; j < item.length; j++){
                var record = item[j];
                $("<td>").html(record["value"]).appendTo(tr);
            }
        }
    }
}