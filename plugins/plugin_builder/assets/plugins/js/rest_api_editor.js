var rapi_editor;
$(document).ready(function(e){
    rapi_editor = CodeMirror.fromTextArea(document.getElementById("rapi_edit_area"), {
        lineNumbers: true,
        mode: "php",
        indentUnit: 4,
        indentWithTabs: true,
        theme: "ayu-mirage"
    });

    load_rapi_edit_list();
    $("#rapi_edit_select_tb").on("click", select_api_content );
    $("#rapi_edit_select_doc").on("click", select_api_doc );
    $("#rapi_edit_save_data").on("click", save_api_content );
});

function save_api_content(){
    var api_name = $("#rapi_edit_tbname").val();
    var plugin_name = $("#plugin_name").val();
    var api_name = $("#rapi_edit_tbname").val();

    $.ajax({
        url: "/plugins/" + plugin_name + "/include/classes/plugin_rapi_editor.php",
        data: {
            type: "save_rapi_content",
            plugin_name: plugin_name,
            api_name: api_name,
            content: rapi_editor.getValue()
        },
        type: "post",
        dataType: "json",
        success: function(data ){
            if (data["status"] == "success"){
                toastr.success("successfuly, saved");
            }
        }
    })     
}

function select_api_content(){
    var api_name = $("#rapi_edit_tbname").val();
    var plugin_name = $("#plugin_name").val();
    $.ajax({
        url: "/plugins/" + plugin_name + "/include/classes/plugin_rapi_editor.php",
        data: {
            type: "load_rapi_content",
            plugin_name: $("#plugin_name").val(),
            api_name: api_name
        },
        type: "post",
        dataType: "json",
        success: function(data ){
            if (data["status"] == "success"){
                rapi_editor.setValue(data["content"]);
            }
        }
    })    
}

function select_api_doc(){
    var api_name = $("#rapi_edit_tbname").val();
    var plugin_name = $("#plugin_name").val();
    $.ajax({
        url: "/plugins/" + plugin_name + "/include/classes/plugin_rapi_editor.php",
        data: {
            type: "load_rapi_doc",
            plugin_name: $("#plugin_name").val(),
            api_name: api_name
        },
        type: "post",
        dataType: "json",
        success: function(data ){
            if (data["status"] == "success"){
                rapi_editor.setValue(data["doc"]);
            }
        }
    }) 
}

function load_rapi_edit_list(){
    var plugin_name = $("#plugin_name").val();
    $.ajax({
        url: "/plugins/" + plugin_name + "/include/classes/plugin_rapi_editor.php",
        data: {
            type: "rapi_list",
            plugin_name: $("#plugin_name").val()
        },
        type: "post",
        dataType: "json",
        success: function(data ){
            if (data["status"] == "success"){
                init_rapi_edit_list(data["data"]);
            }
        }
    })
}

function init_rapi_edit_list(data){
    for(var i = 0; i < data.length; i++ ){
        var item = data[i];
        $("<option>").attr("value", item).text(item).appendTo($("#rapi_edit_tbname"));
    }
}