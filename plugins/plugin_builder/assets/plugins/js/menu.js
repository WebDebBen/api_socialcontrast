$(document).ready(function(){
    load_menu_data();
    $("#add_menu_item").on("click", add_menu_modal);
    $("#menu_save_record").on("click", save_menu_data);
});

function save_menu_data(){
    var plugin_name = $("#plugin_name").val();

    $.ajax({
        url: "/plugins/" + plugin_name + "/include/classes/plugin_menu.php",
        data:{
            type: "save_plugin_menu",
            plugin_name: plugin_name,
            data_id: $("#data-menu-id").val(),
            menu_id: $("#modal_menu_id").val(),
            menu_parent: $("#modal_menu_parent").val(),
            menu_link: $("#modal_menu_link").val(),
            menu_name: $("#modal_menu_name").val()
        },
        type: "post",
        dataType: "json",
        success: function(data){
            $("#menu-edit-modal").modal("hide");
            init_menu_data(data);
            toastr.success("success");
        }
    });
}

function add_menu_modal(){
    $("#data-menu-id").val("-1");
    $(".modal_menu_input").val("");
    $("#menu-edit-modal").modal("show");
}

function load_menu_data(){
    var plugin_name = $("#plugin_name").val();
    $.ajax({
        url: "/plugins/" + plugin_name + "/include/classes/plugin_menu.php",
        data:{
            type: "load_plugin_menu",
            plugin_name: plugin_name
        },
        type: "post",
        dataType: "json",
        success: function(data){
            init_menu_data(data);
        }
    });
}

function init_menu_data(data){
    var tbody = $("#menu_list");
    $(tbody).html("");
    for (var i = 0; i < data.length; i++){
        var item = data[i];
        var tr = $("<tr>").appendTo(tbody);
        $("<td>").addClass("menu-id").text(item["id"]).appendTo(tr);
        $("<td>").addClass("menu-parent").text(item["parent"]).appendTo(tr);
        $("<td>").addClass("menu-name").text(item["name"]).appendTo(tr);
        $("<td>").addClass("menu-link").text(item["link"]).appendTo(tr);
        var action_td = $("<td>").addClass("menu-action").appendTo(tr);

        $("<button>").attr("type", "button")
            .attr("data-id", item["id"])
            .on("click", function(){
                var tr = $(this).parent().parent();
                var menu_id = $(tr).find(".menu-id").text();
                var menu_parent = $(tr).find(".menu-parent").text();
                var menu_name = $(tr).find(".menu-name").text();
                var menu_link = $(tr).find(".menu-link").text();
                $("#modal_menu_id").val(menu_id);
                $("#data-menu-id").val($(this).attr("data-id"));
                $("#modal_menu_parent").val(menu_parent);
                $("#modal_menu_name").val(menu_name);
                $("#modal_menu_link").val(menu_link);
                $("#menu-edit-modal").modal("show");
            })
            .addClass("btn btn-primary").text("Edit").appendTo(action_td);
        $("<button>").attr("type", "button")
            .attr("data-id", item["id"])
            .on("click", function(){
                var id = $(this).attr("data-id");
                $.ajax({
                    url: "/plugins/" + plugin_name + "/include/classes/plugin_menu.php",
                    data:{
                        type: "delete_plugin_menu",
                        data_id: id,
                        plugin_name: plugin_name
                    },
                    type: "post",
                    dataType: "json",
                    success: function(data){
                        init_menu_data(data);
                        $("#menu-edit-modal").modal("hide");
                        toastr.success("success");
                    }
                });
            })
            .addClass("btn btn-danger").text("Delete").appendTo(action_td);
    }
}