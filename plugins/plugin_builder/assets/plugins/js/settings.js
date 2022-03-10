$(document).ready(function(){
    init_settings_data();
    $("#save_new_st_setting").on("click", save_setting_item );
});

function save_setting_item(){
    var st_name = $("#new_st_setting_name").val();
    var st_value = $("#new_st_setting_value").val();
    if (st_name == "" || st_value == "" ) return;

    $.ajax({
        url: "/plugins/plugin_builder/include/classes/plugin_settings.php",
        data: {
            type: "save_settings",
            plugin_name: $("#plugin_name").val(),
            setting_name: st_name,
            setting_value: st_value
        },
        type: "post",
        dataType: "json",
        success: function(res ){
            if (res["status"] == "success"){
                add_setting_item({name: st_name, value:st_value });
                toastr.success("Added, successfuly");
            }else if(res["status"] == "duplicated"){
                toastr.error("The setting name is duplicated");
            }
        } 
    });
}

function update_setting_item(){
    var tr = $(this).parent().parent();
    var st_name = $(this).attr("data-name");
    var st_value = $(tr).find(".setting_value_input").val();
    if (st_name == "" || st_value == "" ) return;
    var self = this;
    $.ajax({
        url: "/plugins/plugin_builder/include/classes/plugin_settings.php",
        data: {
            type: "update_settings",
            plugin_name: $("#plugin_name").val(),
            setting_name: st_name,
            setting_value: st_value
        },
        type: "post",
        dataType: "json",
        success: function(res ){
            if (res["status"] == "success"){
                $(tr).find(".setting_value_td").html(st_value );
                $(self).addClass("hide");
                $(tr).find(".btn_set_delete").removeClass("hide");
                $(tr).find(".btn_set_update").addClass("hide");
                $(tr).find(".btn_set_edit").removeClass("hide");

                toastr.success("Added, successfuly");
            }else if(res["status"] == "duplicated"){
                toastr.error("The setting name is duplicated");
            }
        } 
    });
}

function init_settings_data(){
    $.ajax({
        url: "/plugins/plugin_builder/include/classes/plugin_settings.php",
        data: {
            type: "setting_list",
            plugin_name: $("#plugin_name").val()
        },
        type: "post",
        dataType: "json",
        success: function(data ){
            if (data["status"] == "success"){
                init_setting_list(data["data"]);
            }
        }
    });
}

function init_setting_list(data ){
    var parent = $("#st_tbody");
    $(parent).find("tr.st-script-tr").remove();
    if (data && !data["items"]) return;
    data = data["items"];
    for (var i = 0; i < data.length; i++ ){
        add_setting_item(data[i])
    }
}

function add_setting_item(data ){
    var parent = $("#st_tbody");
    var tr = $("<tr>").appendTo(parent );
    var td = $("<td>").addClass("setting_name_td").appendTo(tr );
    $("<span>").text(data["name"]).appendTo(td);
    var td = $("<td>").addClass("setting_value_td").appendTo(tr );
    $("<span>").text(data["value"]).appendTo(td);

    td = $("<td>").appendTo(tr);
    $("<button>").attr("type", "button").attr("data-name", data["name"]).attr("data-value", data["value"])
        .on("click", edit_setting_item )
        .text("Edit").addClass("btn btn-primary btn_set_edit").appendTo(td);
    $("<button>").attr("type", "button").attr("data-name", data["name"])
        .on("click", delete_setting_item )
        .text("Delete").addClass("btn btn-danger btn_set_delete").appendTo(td);
    $("<button>").attr("type", "button")
    .on("click", update_setting_item )
    .attr("data-name", data["name"])
    .text("Update").addClass("btn btn-success btn_set_update hide").appendTo(td);        
}

function edit_setting_item(e){
    e.preventDefault();
    var tr = $(this).parent().parent();
    var name = $(this).attr("data-name");
    var value = $(this).attr("data-value");
    //$(tr).find(".setting_name_td").html($("<input>").addClass("setting_name_input").val(name).html());
    $(tr).find(".setting_value_td").html("");
    $("<input>").addClass("setting_value_input").val(value).appendTo($(tr).find(".setting_value_td"));
    $(this).addClass("hide");
    $(tr).find(".btn_set_delete").addClass("hide");
    $(tr).find(".btn_set_update").removeClass("hide");
}

function delete_setting_item(){
    if (!confirm("do you really delete this script?")){
        return;
    }
    var self = this;
    $.ajax({
        url: "/plugins/plugin_builder/include/classes/plugin_settings.php",
        data: {
            type: "delete_setting_item",
            plugin_name: $("#plugin_name").val(),
            setting_name: $(this).attr("data-name")
        },
        type: "post",
        dataType: "json",
        success: function(data ){
            if (data["status"] == "success"){
                toastr.success("Deleted, successfuly");
                $(self).parent().parent().remove();
            }else{
                toastr.error("File not exists");
            }
        }
    }); 
}