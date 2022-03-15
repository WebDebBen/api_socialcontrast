var tq_editor;
$(document).ready(function(){
    $("#run_tq_query").on("click", function(e){
        $.ajax({
            url: "/plugins/plugin_builder/include/classes/plugin_tablequery.php",
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

        $.ajax({
            url: "/plugins/plugin_builder/include/classes/plugin_tablequery.php",
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
                    //$("<p>").html(res["result"][2]).appendTo(parent);
                    toastr.error(res["result"][2]);
                }else{
                    toastr.success("saved, successfuly");
                }
                init_tq_query_list();
            }
        });
    });

    $("#load_tq_query").on("click", function(){
        var query_name = $("#tq_query_list").val();
        if (query_name == ""){
            toastr.error("Please input the Query Name");
            return;
        }

        $.ajax({
            url: "/plugins/plugin_builder/include/classes/plugin_tablequery.php",
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

    init_tq_query_list();
});

function init_tq_query_list(){
    $.ajax({
        url: "/plugins/plugin_builder/include/classes/plugin_tablequery.php",
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