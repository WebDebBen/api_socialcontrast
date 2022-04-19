$(document).ready(function(){
    load_commit_list();
    $("#save_commit_item").on("click", save_commit_item );
});

function save_commit_item(){
    //var commit_name = $("#new_commit_name_input").val();
    var commit_short_desc = $("#new_commit_short_desc_input").val();
    var commit_desc = $("#new_commit_desc_input").val();
    var plugin_name = $("#plugin_name").val();

    if (commit_desc == "" ) return;

    $.ajax({
        url: "/plugins/" + plugin_name + "/include/classes/plugin_commits.php",
        data: {
            type: "save_commit",
            plugin_name: plugin_name,
            //commit_name: commit_name,
            commit_desc: commit_desc,
            commit_short_desc: commit_short_desc,
        },
        type: "post",
        dataType: "json",
        success: function(res ){
            if (res["status"] == "success"){
                //add_commit_item({name:commit_name, description:commit_desc, short_description: commit_short_desc, is_commited: 1});
                load_commit_list();
                toastr.success("Added, successfuly");
            }else if(res["status"] == "duplicated"){
                toastr.error("The commit name is duplicated");
            }
        } 
    });
}

function load_commit_list(){
    var plugin_name = $("#plugin_name").val();
    $.ajax({
        url: "/plugins/" + plugin_name+ "/include/classes/plugin_commits.php",
        data: {
            type: "commit_list",
            plugin_name: $("#plugin_name").val()
        },
        type: "post",
        dataType: "json",
        success: function(data ){
            if (data["status"] == "success"){
                var result = data["result"];
                init_commit_list(result);
            }
        }
    });
}

function init_commit_list(data ){
    var parent = $("#commit_tbody");
    $(parent).find("tr.commit-tr").remove();
    var tmp_version = parseInt(data["version"]) < 10 ? "0" + data["version"] : data["version"];
    $("#new_commit_version").val(data["name"] + "." + tmp_version)
    var plugins = data["plugins"];
    for (var i = 0; i < plugins.length; i++ ){
        add_commit_item(plugins[i])
    }
}

function add_commit_item(data){
    var parent = $("#commit_tbody");
    var tr = $("<tr>").addClass("commit-tr").appendTo(parent );
    var td = $("<td>").appendTo(tr );
    var tmp_version = parseInt(data["version"]) < 10 ? "0" + data["version"] : data["version"];
    var name = "";
    if (data["is_commited"] == 1 || data["is_commited"] == "1"){
        name = data["name"] + "." + tmp_version;
    }else{
        name = "<a href='/plugins/" + $("#plugin_name").val() + "/commits/" + data["name"] + "." + tmp_version + ".zip'>" + data["name"] + "." + tmp_version + "</a>";
    }
    $("<span>").html(name).appendTo(td);
    var td = $("<td>").appendTo(tr );
    $("<span>").text(data["short_description"]).appendTo(td);
    var td = $("<td>").appendTo(tr );
    $("<span>").text(data["description"]).appendTo(td);

    td = $("<td>").appendTo(tr);
    if (data["is_commited"] == 1 || data["is_commited"] == "1" ){
        $("<button>").attr("type", "button")
            .attr("data-name", data["name"] )
            .attr("data-version", data["version"] )
            .attr("data-description", data["description"] )
            .attr("data-short_description", data["short_description"] )
            .on("click", set_commit_item )
            .text("Commit").addClass("btn btn-primary btn-commit").appendTo(td);
    }
    $("<button>").attr("type", "button")
        .attr("data-name", data["name"])
        .attr("data-version", data["version"])
        .on("click", delete_commit_item )
        .text("Delete").addClass("btn btn-danger").appendTo(td);
}

function set_commit_item(){
    if (!confirm("do you really commit?")){
        return;
    }
    var self = this;
    var plugin_name = $("#plugin_name").val();
    $.ajax({
        url: "/plugins/" + plugin_name + "/include/classes/plugin_commits.php",
        data: {
            type: "set_commit",
            plugin_name: $("#plugin_name").val(),
            commit_name: $(this).attr("data-name"),
            commit_version: $(this).attr("data-version")
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
    var plugin_name = $("#plugin_name").val();
    var self = this;
    $.ajax({
        url: "/plugins/" + plugin_name + "/include/classes/plugin_commits.php",
        data: {
            type: "delete_commit",
            plugin_name: $("#plugin_name").val(),
            commit_name: $(this).attr("data-name"),
            commit_version: $(this).attr("data-version")
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