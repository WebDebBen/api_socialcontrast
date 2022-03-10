$(document).ready(function(){
    init_database_script();
    $("#save_new_ds_script").on("click", save_new_ds_script );
});

function save_new_ds_script(){
    var script_name = $("#new_ds_script_input").val();
    if (script_name == "" ) return;

    $.ajax({
        url: "/plugins/plugin_builder/include/classes/plugin_database_script.php",
        data: {
            type: "save_ds_script",
            plugin_name: $("#plugin_name").val(),
            script_name: script_name
        },
        type: "post",
        dataType: "json",
        success: function(res ){
            if (res["status"] == "success"){
                add_ds_script_item(script_name );
                toastr.success("Added, successfuly");
            }else if(res["status"] == "duplicated"){
                toastr.error("The script name is duplicated");
            }
        } 
    });
}

function init_database_script(){
    $.ajax({
        url: "/plugins/plugin_builder/include/classes/plugin_database_script.php",
        data: {
            type: "script_list",
            plugin_name: $("#plugin_name").val()
        },
        type: "post",
        dataType: "json",
        success: function(data ){
            if (data["status"] == "success"){
                init_ds_scripts_list(data["scripts"]);
            }
        }
    });
}

function init_ds_scripts_list(data ){
    var parent = $("#ds_tbody");
    $(parent).find("tr.ds-script-tr").remove();
    for (var i = 0; i < data.length; i++ ){
        add_ds_script_item(data[i])
    }
}

function add_ds_script_item(text ){
    var parent = $("#ds_tbody");
    var tr = $("<tr>").addClass("ds_script_item_tr").appendTo(parent );
    var td = $("<td>").appendTo(tr );
    $("<span>").text(text).appendTo(td);

    td = $("<td>").appendTo(tr);
    $("<button>").attr("type", "button").attr("data-name", text )
        .on("click", edit_ds_content )
        .text("Edit").addClass("btn btn-primary").appendTo(td);
    $("<button>").attr("type", "button").attr("data-name", text)
        .on("click", delete_ds_content )
        .text("Delete").addClass("btn btn-danger").appendTo(td);
}

function edit_ds_content(e){
    e.preventDefault();
    var self = this;
    $.ajax({
        url: "/plugins/plugin_builder/include/classes/plugin_database_script.php",
        data: {
            type: "load_ds_content",
            plugin_name: $("#plugin_name").val(),
            script_name: $(this).attr("data-name")
        },
        type: "post",
        dataType: "json",
        success: function(data ){
            if (data["status"] == "success"){
                $("#ol_plugin_name").val($("#plugin_name").val());
                $("#ol_script_name").val($(self).attr("data-name"));
                $("#ol_editor_type").val("database_script");
                editor.setValue(data["data"]);
                show_overlay();
            }else{
                toastr.error("File not exists");
            }
        }
    });   
}

function delete_ds_content(){
    if (!confirm("do you really delete this script?")){
        return;
    }
    var self = this;
    $.ajax({
        url: "/plugins/plugin_builder/include/classes/plugin_database_script.php",
        data: {
            type: "delete_ds_script",
            plugin_name: $("#plugin_name").val(),
            script_name: $(this).attr("data-name")
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