$(document).ready(function(){
    load_plugins();

    $("#save_new_plugin").on("click", save_new_plugin );
});

function save_new_plugin(){
  var plugin_name = $("#new_plugin").val();
  var plugin_type = $("#new_plugin_type").val();

  if (plugin_name == ""){
    toastr.error("Please input the plugin name");
    return;
  }
  $.ajax({
    url: "/plugins/plugin_builder/include/classes/plugins.php",
    data: {
      type: "save_plugin",
      name: plugin_name,
      plugin_type: plugin_type
    },
    type: "post",
    dataType: "json",
    success: function(res ){
      if (res["status"] == "success"){
        add_tr($("#plugin_tbody"), plugin_name, plugin_type );
        toastr.success("Added, successfuly");
      }else if(res["status"] == "duplicated"){
        toastr.error("The plugin name is duplicated");
      }
    }
  });
}

function load_plugins(){
    $.ajax({
        url: "/plugins/plugin_builder/include/classes/plugins.php",
        data: {
          type: "load_plugins"
        },
        type: "post",
        dataType: "json",
        success: function(res ){
          if (res["status"] == "success"){
            init_plugins(res["result"]);
          }
        }
    });
}

function init_plugins(data ){
  var parent = $("#plugin_tbody");
  $(parent).find(".plugin_tr").remove();
  for (var i = 0;i < data.length; i++ ){
    var item = data[i];
    add_tr(parent, item["name"], item["plugin_type"] );
  }
}

function add_tr(parent, name, type ){
  var tr = $("<tr>").addClass("plugin_tr").appendTo(parent );
  var plugin_name = toCamleCaseString(name).toLowerCase();
  var td = $("<td>").addClass("plugin_type").appendTo(tr);
  $("<span>").text(type).appendTo(td);
  var td = $("<td>").addClass("plugin_name").appendTo(tr);
  $("<span>").text(name).appendTo(td);
  td = $("<td>").addClass("plugin_view").appendTo(tr);
  //$("<a>").attr("href", "/admin/plugins/edit/" + plugin_name).text("View").appendTo(td);
  $("<a>").attr("href", "/admin/plugins/" + plugin_name + "/plugin_editor/").text("View").appendTo(td);
  td = $("<td>").addClass("plugin_action").appendTo(tr);
  if (name != "plugin_builder"){
    $("<button>").addClass("btn btn-danger").text("Delete")
        .attr("data-name", name )
        .attr("data-type", type )
        .on("click", function(e){
          e.preventDefault();
          if (!confirm("do you really delete this plugin?")) return;
          var name = $(this).attr("data-name");
          var plugin_type = $(this).attr("data-type");
          var parent_tr = $(this).parent().parent();
          $.ajax({
            url: "/plugins/plugin_builder/include/classes/plugins.php",
            data: {
              type: "delete_plugin",
              name: name,
              plugin_type: plugin_type
            },
            type: "post",
            dataType: "json",
            success: function(res ){
              if (res["status"] == "success"){
                $(parent_tr).remove();
                toastr.success("Deleted, successfuly");
              }
            }
          });
        })
        .appendTo(td);
  }
}