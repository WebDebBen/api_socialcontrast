var admin_editor;
$(document).ready(function(e){
    $("#admin_edit_select_tb").on("click", select_admin_interface);
    $("#admin_edit_save_data").on("click", save_admin_interface);
    admin_editor = CodeMirror.fromTextArea(document.getElementById("admin_interface_area"), {
        lineNumbers: true,
        mode: "php",
        indentUnit: 4,
        indentWithTabs: true,
        theme: "ayu-mirage"
    });

    $("#ai_interface_add_btn").on("click", admin_interface_new);
    $("#admin_edit_delete_data").on("click", admin_interface_delete);
    $("#ai_interfaces_select").on("change", admin_interface_change);
    ai_new_interface_load();
});

function admin_interface_change(){
    if ($("#ai_interfaces_select option:selected").hasClass("ai_origin")){
        $("#admin_edit_delete_data").addClass("hide");
    }else{
        $("#admin_edit_delete_data").removeClass("hide");
    }
}

function admin_interface_delete(){
    if (!confirm("Are you going to delete this interface?")){
        return;
    }
    var plugin_name = $("#plugin_name").val();
    var interface_name = $("#ai_interfaces_select").val();
    $.ajax({
        url: "/plugins/" + plugin_name + "/include/classes/plugin_admin_interface.php",
        data: {
            type: "delete_interface_data",
            plugin_name: $("#plugin_name").val(),
            interface_name: interface_name
        },
        type: "post",
        dataType: "json",
        success: function(res ){
            toastr.success("Success");
            ai_new_interface_load();
            $("#admin_edit_delete_data").addClass("hide");
        }
    });
}

function ai_new_interface_load(){
    var plugin_name = $("#plugin_name").val();
    $.ajax({
        url: "/plugins/" + plugin_name + "/include/classes/plugin_admin_interface.php",
        data: {
            type: "load_new_interfaces",
            plugin_name: $("#plugin_name").val()
        },
        type: "post",
        dataType: "json",
        success: function(res ){
            res = res["data"];
            var parent = $("#ai_interfaces_select");
            $(parent).find(".ai_new_option").remove();
            for (var i = 0; i < res.length; i++){
                $("<option>").addClass("ai_new_option")
                    .val(res[i]["file_name"])
                    .text(res[i]["interface_name"])
                    .appendTo(parent);
            }
        }
    });
}

function admin_interface_new(){
    var interface_name = $("#ai_interface_name").val();
    var plugin_name = $("#plugin_name").val();
    if (interface_name == "" || admin_editor.getValue() == ""){
        toastr.error("Please input the interface name or content");
        return;
    }

    $.ajax({
        url: "/plugins/" + plugin_name + "/include/classes/plugin_admin_interface.php",
        data: {
            type: "new_interface_data",
            plugin_name: $("#plugin_name").val(),
            interface_name: interface_name,
            content: admin_editor.getValue()
        },
        type: "post",
        dataType: "json",
        success: function(res ){
            if (res["status"] == "exist"){
                toastr.error("file name is duplicated");
            }else{
                toastr.success("Success");
                ai_new_interface_load();
            }
        }
    });
}

function select_admin_interface(){
    var plugin_name = $("#plugin_name").val();
    $.ajax({
        url: "/plugins/" + plugin_name + "/include/classes/plugin_admin_interface.php",
        data: {
            type: "load_interface_data",
            plugin_name: $("#plugin_name").val(),
            interface_name: $("#ai_interfaces_select").val()
        },
        type: "post",
        dataType: "json",
        success: function(res ){
            admin_editor.setValue(res["data"]);
        }
    });
}

function save_admin_interface(){
    var plugin_name = $("#plugin_name").val();
    $.ajax({
        url: "/plugins/" + plugin_name + "/include/classes/plugin_admin_interface.php",
        data: {
            type: "save_interface_data",
            plugin_name: $("#plugin_name").val(),
            interface_name: $("#ai_interfaces_select").val(),
            content: admin_editor.getValue()
        },
        type: "post",
        dataType: "json",
        success: function(res ){
            toastr.success("Success");
        }
    });
}