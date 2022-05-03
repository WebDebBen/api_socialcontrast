var ai_editor;
$(document).ready(function(){
    init_ai_folder_tree();
	init_ai_folder_list();

	ai_editor = CodeMirror.fromTextArea(document.getElementById("ai_script_area"), {
        lineNumbers: true,
        mode: "php",
        indentUnit: 4,
        indentWithTabs: true,
        theme: "ayu-mirage"
    });
});

function init_ai_folder_tree(){
	var plugin_name = $("#plugin_name").val();
	$.ajax({
		url: "/plugins/" + plugin_name + "/include/classes/plugin_admin_interfaces.php",
		data:{
			type: "get_folder_structure",
			plugin_name: plugin_name,
		},
		type: "post",
		dataType: "json",
		success: function(data){
			$('#ai_jqfolder_tree').jstree({
				'core' : {
					'data' :data
				}
			}).on("changed.jstree", function (e, data) {
				//console.log(data.node.id); // newly selected
				init_ai_folder_list("/" + data.node.id);
			});
		}
	});
}

function init_ai_folder_list(parent = ""){
	var plugin_name = $("#plugin_name").val();
	$.ajax({
		url: "/plugins/" + plugin_name + "/include/classes/plugin_admin_interfaces.php",
		data:{
			type: "get_folder_list",
			plugin_name: plugin_name,
			parent: parent
		},
		type: "post",
		dataType: "json",
		success: function(data){
			display_ai_folder_list(data, parent);
		}
	});
}

function display_ai_folder_list(data, parent){
	var parent_div = $("#ai_jq_folder_list");
	$(parent_div).html("");
	for (var i = 0; i < data["folders"].length; i++){
		var text = data["folders"][i];

		var div = $("<div>").attr("data-type", "folder")
						.attr("data-path", parent + "/" + text)
						.addClass("ai_list_item")
						.on("click", function(e){
							$(".ai_list_item").removeClass("active");
							$(this).addClass("active");
						})
						.on("dblclick", function(e){
							e.preventDefault();
							init_ai_folder_list($(this).attr("data-path"));
						}).appendTo(parent_div);
		var i_class = "fa fa-folder";
		$("<i>").addClass(i_class).appendTo(div);
		$("<span>").text(text).appendTo(div);
	}

	for (var i = 0; i < data["files"].length; i++){
		var text = data["files"][i];

		var div = $("<div>").attr("data-type", "file")
						.attr("data-path", parent + "/" + text)
						.addClass("ai_list_item")
						.on("dblclick", function(e){
							$.ajax({
								url: "/plugins/" + plugin_name + "/include/classes/plugin_admin_interfaces.php",
								data:{
									type: "get_file_content",
									path: $(this).attr("data-path"),
									plugin_name: plugin_name
								},
								type: "post",
								dataType: "json",
								success: function(data){
									ai_editor.setValue(data["content"]);
								}
							});
						})
						.on("click", function(e){
							e.preventDefault();
							init_ai_folder_list($(this).attr("data-path"));
							$(".ai_list_item").removeClass("active");
							$(this).addClass("active");
						}).appendTo(parent_div);
		var i_class = "fa fa-file";
		$("<i>").addClass(i_class).appendTo(div);
		$("<span>").text(text).appendTo(div);
	}
}