$(document).ready(function(){
    load_commit_list();
    $("#save_commit_item").on("click", save_commit_item );
});

function save_commit_item(){
    var commit_name = $("#new_commit_name_input").val();
    var commit_desc = $("#new_commit_desc_input").val();

    if (commit_name == "" || commit_desc == "" ) return;

    $.ajax({
        url: "/plugins/plugin_builder/include/classes/plugin_commits.php",
        data: {
            type: "save_commit",
            plugin_name: $("#plugin_name").val(),
            commit_name: commit_name,
            commit_desc: commit_desc
        },
        type: "post",
        dataType: "json",
        success: function(res ){
            if (res["status"] == "success"){
                add_commit_item({name:commit_name, description:commit_desc, is_commited: 1});
                toastr.success("Added, successfuly");
            }else if(res["status"] == "duplicated"){
                toastr.error("The commit name is duplicated");
            }
        } 
    });
}

function load_commit_list(){
    $.ajax({
        url: "/plugins/plugin_builder/include/classes/plugin_commits.php",
        data: {
            type: "commit_list",
            plugin_name: $("#plugin_name").val()
        },
        type: "post",
        dataType: "json",
        success: function(data ){
            if (data["status"] == "success"){
                init_commit_list(data["result"]);
            }
        }
    });
}

function init_commit_list(data ){
    var parent = $("#commit_tbody");
    $(parent).find("tr.commit-tr").remove();
    for (var i = 0; i < data.length; i++ ){
        add_commit_item(data[i])
    }
}

function add_commit_item(data){
    var parent = $("#commit_tbody");
    var tr = $("<tr>").appendTo(parent );
    var td = $("<td>").appendTo(tr );
    $("<span>").text(data["name"]).appendTo(td);
    var td = $("<td>").appendTo(tr );
    $("<span>").text(data["description"]).appendTo(td);

    td = $("<td>").appendTo(tr);
    if (data["is_commited"] == 1 || data["is_commited"] == "1" ){
        $("<button>").attr("type", "button").attr("data-name", data["name"] ).attr("data-description", data["description"] )
            .on("click", set_commit_item )
            .text("Commit").addClass("btn btn-primary btn-commit").appendTo(td);
    }
    $("<button>").attr("type", "button").attr("data-name", data["name"])
        .on("click", delete_commit_item )
        .text("Delete").addClass("btn btn-danger").appendTo(td);
}

function set_commit_item(){
    if (!confirm("do you really commit?")){
        return;
    }
    var self = this;
    $.ajax({
        url: "/plugins/plugin_builder/include/classes/plugin_commits.php",
        data: {
            type: "set_commit",
            plugin_name: $("#plugin_name").val(),
            commit_name: $(this).attr("data-name")
        },
        type: "post",
        dataType: "json",
        success: function(data ){
            if (data["status"] == "success"){
                toastr.success("Commited, successfuly");
                $(self).parent().parent().find(".btn-commit").remove();
                $(".ds_script_item_tr").remove();
            }else{
                toastr.error("File not exists");
            }
        }
    });
}

function delete_commit_item(){
    if (!confirm("do you really delete?")){
        return;
    }
    var self = this;
    $.ajax({
        url: "/plugins/plugin_builder/include/classes/plugin_commits.php",
        data: {
            type: "delete_commit",
            plugin_name: $("#plugin_name").val(),
            commit_name: $(this).attr("data-name")
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