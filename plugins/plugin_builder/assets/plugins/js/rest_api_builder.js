var base_url;
var base_api_url;
var api_sel_tables = [];
var table_infos = [];

var wizard_index = 1;
$(document).ready(function(){
    api_initialize();
    load_api_table_list();
    $("#api_prev_btn").on("click", api_prev_wizard );
    $("#api_next_btn").on("click", api_next_wizard );
    $("#api_gen_btn").on("click", generate_rest_api );
    $("#api_all-table-check").on("click", check_api_table_all );
});


function check_api_table_all(){
    var is_checked = $(this).is(":checked");
    if (is_checked ){
        $(".table-check").prop("checked", true );
    }else{
        $(".table-check").prop("checked", false );
    }
}

function generate_rest_api(){
    $.ajax({
        url: "/plugins/plugin_builder/include/classes/plugin_generate.php",
        data: {
            plugin_name: $("#plugin_name").val(),
            table_infos: JSON.stringify(table_infos),
            tables: JSON.stringify(api_sel_tables )
        },
        type: "post",
        dataType: "json",
        success: function(data ){ 
            if (data["status"] == "success"){
                var filename = data["data"]["apidoc"];
                $("#api_generate_result h3").html("Successfully generated");
                $("#api_generate_result .api_url").html("<a target='_blank' href='/plugins/plugin_creator/" + $("#plugin_name").val() + "/api/documentation/" + filename + "'>" + filename + "</a>");
            }else{
                $("#api_generate_result h3").html("Failed");
                $("#api_generate_result .api_url").html("");
            }
        }
    });
}

function api_initialize(){
    base_url = $("#base_url").val();
    base_api_url = $("#base_api_url").val();
    api_sel_tables = [];
    wizard_index = 1;
}

function load_api_table_list(){
    $.ajax({
        url: "/plugins/plugin_builder/include/classes/plugin_showtables.php",
        data: {},
        type: "get",
        dataType: "json",
        success: function(data ){
            if (data["status"] == "success"){
                init_api_table_list(data["data"]);
            }
        }
    })
}

function init_api_table_list(data ){
    var parent = $("#api_table-wrap");

    for(var i = 0; i < data.length; i++ ){
        var item = data[i];
        var table_item = $("<div>").addClass("form-check table-box").appendTo(parent );
        $("<input>").addClass("form-check-input table-check").attr("type","checkbox")
                    .attr("id", "api_table-check" + i )
                    .attr("data-table", item )
                    .appendTo(table_item );
        $("<label>").addClass("form-check-label table-label").attr("for", "api_table-check" + i )
                    .text(item ).appendTo(table_item );
    }
}

function load_api_table_infos(){
    $.ajax({
        url: "/plugins/plugin_builder/include/classes/plugin_tables.php",
        data: {
            tables: JSON.stringify(api_sel_tables)
        },
        type: "post",
        dataType: "json",
        success: function(data ){
            if (data["status"] == "success"){
                load_api_table_info(data["data"]);
            }
        }
    })
}

function load_api_table_info(data ){
    table_infos = data;
    var parent = $("#api_table-info");
    $(parent).html("");
    var table = $("<table>").addClass("table").appendTo(parent );

    for (var i = 0; i < table_infos.length; i++ ){
        var item = table_infos[i];
        var table_name = item["table_name"];
        var columns = item["columns"];
        var tr = $("<tr class='table-name-wrap'>").appendTo(table );
        $("<td>").html("<table class='table-name-tb'><tr><td>" + (i + 1) + ". <b>" + table_name + "</b></td></tr></table>").appendTo(tr );
        var tr = $("<tr>").appendTo(table );
        var td = $("<td>").appendTo(tr );
        var sub_table = $("<table>").appendTo(td );
        var sub_tr = $("<tr>").appendTo(sub_table );
        $("<td>").text("Column Name").appendTo(sub_tr );
        $("<td>").text("Column Type").appendTo(sub_tr );
        $("<td>").text("On Add").appendTo(sub_tr );
        $("<td>").text("On Update").appendTo(sub_tr );
        $("<td>").text("Retrieve Total").appendTo(sub_tr );
        $("<td>").text("Foreign Table").appendTo(sub_tr );
        $("<td>").text("Accepted").appendTo(sub_tr );

        for (var j = 0; j < columns.length; j++ ){
            var col_item = columns[j];
            sub_tr = $("<tr>").appendTo(sub_table );
            $("<td>").text(col_item["column_name"]).appendTo(sub_tr );
            $("<td>").text(col_item["column_type"]).appendTo(sub_tr );
            var sub_td = $("<td>").appendTo(sub_tr );
            if (col_item["column_default"]){
                $("<input>").attr("type", "checkbox").appendTo(sub_td );
            }else{
                $("<input>").attr("type", "checkbox").attr("checked", true ).attr("disabled", true ).appendTo(sub_td );
            }
            var sub_td = $("<td>").appendTo(sub_tr );
            $("<input>").attr("type", "checkbox").appendTo(sub_td );
            sub_td = $("<td>").appendTo(sub_tr );
            $("<input>").attr("type", "checkbox").appendTo(sub_td );

            var referenced_table_name = api_sel_tables.indexOf(col_item["referenced_table_name"]) > -1 ? col_item["referenced_table_name"] : "";
            table_infos[i]["columns"][j]["referenced_table_name"] = referenced_table_name;
            $("<td>").text(api_sel_tables.indexOf(col_item["referenced_table_name"]) > -1 ? col_item["referenced_table_name"] : "").appendTo(sub_tr );
            sub_td = $("<td>").appendTo(sub_tr );
            if (col_item["data_type"] == "enum"){
                $("<input>").val(col_item["column_default"]).appendTo(sub_td );
            }else{
                $("<input>").val(col_item["column_default"]).appendTo(sub_td );
            }
        }
        var sub_tr = $("<tr>").appendTo(sub_table );
        $("<td>").appendTo()
    }
}

function api_prev_wizard(){
    switch(wizard_index ){
        case 1:
            return;
        case 2:
            table_infos = [];
            break;
    }
    wizard_index --;
    switch_wizard(wizard_index, "prev" )
}

function api_next_wizard(){
    switch(wizard_index ){
        case 1:
            api_sel_tables = get_api_sel_tables();
            break;
        //case 2:
        //    table_infos = get_table_infos();
        //    break;
        case 3:
            return;
    }
    wizard_index ++;
    switch_wizard(wizard_index, "next" )
}

function get_api_sel_tables(){
    var tables = $("#api_table-list input.table-check:checked");
    var tmp_arr = [];
    for(var i = 0; i < tables.length; i++ ){
        var item = tables[i];
        tmp_arr.push($(item ).data("table"));
    }
    return tmp_arr;
}

function get_table_infos(){
}

function switch_wizard(index, direction ){
    switch(index ){
        case 1:
            $("#api_table-list").removeClass("hide");
            $("#api_table-info").addClass("hide");
            $("#api_statis-wrap").addClass("hide");

            $("#api_prev_btn").addClass("hide");
            $("#api_next_btn").removeClass("hide");
            break;
        case 2:
            $("#api_table-list").addClass("hide");
            $("#api_table-info").removeClass("hide");
            $("#api_statis-wrap").addClass("hide");
            $("#api_prev_btn").removeClass("hide");
            $("#api_next_btn").removeClass("hide");
            if (direction == "next" ){
                load_api_table_infos();
            }
            break;
        case 3:
            $("#api_table-list").addClass("hide");
            $("#api_table-info").addClass("hide");
            $("#api_statis-wrap").removeClass("hide");
            $("#api_prev_btn").removeClass("hide");
            $("#api_next_btn").addClass("hide");
            $("#api_selected_table").text(api_sel_tables.length + " tables are selected");
            break;
    }
}