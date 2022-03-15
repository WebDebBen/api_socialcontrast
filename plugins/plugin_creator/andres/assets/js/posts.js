base_url = "/plugins/plugin_product_catalog/interfaces/php/posts.php";
upload_url = "/plugins/plugin_builder/include/classes/upload.php";
export_url = "/plugins/plugin_builder/include/classes/export_excel.php";
var table;
var sel_tr;
$(document).ready(function(){
	init_table();
	$("#posts_new").on("click", new_record);
	$("#posts_body").on("click", ".edit-item", edit_record );
	$("#posts_body").on("click", ".delete-item", delete_record );
	$("#export_excel").on("click", export_excel );
	$("#save_record").on("click", save_record );
	$("body").on("click", ".ajax-file-upload-red", function(e){
		e.preventDefault();
		$(this).parent().parent().find("+ .btn").show();
		$(this).parent().parent().parent().find("div[data-type=file]").attr("data-file", "").show();
		$(this).parent().remove()
	});
	$("textarea").trumbowyg();
	var objs = $("select[data-type=relation]");
	for(var i = 0; i < objs.length; i++ ){
		var obj = objs[i];
		var obj_id = $(obj ).attr("id");
		var ref_table = $(obj).attr("data-reftable");
		var ref_field = $(obj).attr("data-reffield");
		set_relation_table_data(obj_id, ref_table, ref_field );
	}
});
function export_excel(){
	$.ajax({
		url: export_url,
		data:{
			table: "posts",
		},
		type: "post",
		dataType: "json",
		success: function(data){
			if (data["status"] == "success" ){
				window.open("/plugins/excels/" + data["file"], "_blank");
			}else{
				toastr.error("failed");
			}
		}
	});
}
function save_record(){
	var id = $("#data-id").val();
	var tr_title = $("#posts_field_title").val();
	var tr_title = $("#posts_field_title").val();
	var tr_content = $("#posts_field_content").trumbowyg('html');
	var tr_description = $("#posts_field_description").trumbowyg('html');
	$.ajax({
		url: base_url,
		data:{
			type: "save",
			id: id,
			title: tr_title,
			title: tr_title,
			content: tr_content,
			description: tr_description,
		},
		type: "post",
		dataType: "json",
		success: function(data){
			if (data["status"] == "success" ){
				if (id == "-1"){
					var table_id = data["id"];
					table.row.add( ["<div class='posts_title'>" + tr_title + "</div>", "<div class='posts_title'>" + tr_title + "</div>", "<div class='posts_content'>" + tr_content + "</div>", "<div class='posts_description'>" + tr_description + "</div>", '<button class="btn btn-xs btn-sm btn-primary mr-6 edit-item" data-id="' + table_id + '"><i class="fa fa-edit"></i></button><button class="btn btn-xs btn-sm btn-secondary delete-item" data-id="'+ table_id + '"><i class="fa fa-trash"></i></button>']).draw( false );
				}else{
					$(sel_tr).find(".posts_title").html(tr_title );
					$(sel_tr).find(".posts_title").html(tr_title );
					$(sel_tr).find(".posts_content").html(tr_content );
					$(sel_tr).find(".posts_description").html(tr_description );
				}
				$("#edit-modal").modal("hide");
			}
		}
	});
}
function new_record(){
	$("#edit-modal input").val("");
	$(".ajax-file-upload-statusbar").remove();
	$("[data-type=file]").show();
	$("[data-type=file]").parent().find("button").show();
	$("#data-id").val("-1");
	$("#edit-modal").modal("show");
}
function delete_record(){
	var id = $(this).attr("data-id");
	sel_tr = $(this).parent().parent();
	if (confirm("Are you going to delete this record?")){
		$.ajax({
			url: base_url,
			data:{
				type: 'delete',
				id: id
			},
			type:"post",
			dataType: "json",
			success: function(data){
				if (data["status"] == "success"){
					table.row('.selected').remove().draw( false );
				}
			}
		})
	}
}
function edit_record(){
	$(".ajax-file-upload-statusbar").remove();
	var id = $(this).attr('data-id');
	sel_tr = $(this).parent().parent();
	$("#data-id").val(id );
	$("#posts_field_title").val($(sel_tr).find(".posts_title").html());
	$("#posts_field_title").val($(sel_tr).find(".posts_title").html());
	$("#posts_field_content").trumbowyg("html",$(sel_tr).find(".posts_content").html());
	$("#posts_field_description").trumbowyg("html",$(sel_tr).find(".posts_description").html());
	$("#edit-modal").modal("show");
}
function init_table(){
	$.ajax({
		url: base_url,
		data:{
			type: "init_table"
		},
		dataType: "json",
		type: "post",
		success: function(data ){
			if (data["status"] == "success" ){
				load_data(data["data"]);
			}
		}
	});
}
function load_data(data ){
	var parent = $("#posts_body");
	for(var i = 0; i < data.length; i++ ){
		var item = data[i];
		var tr = $('<tr>').attr('data-id', item[0]).appendTo(parent );
		td = $("<td>").appendTo(tr);
		$("<div>").addClass("posts_title").html(item[1]).appendTo(td);
		td = $("<td>").appendTo(tr);
		$("<div>").addClass("posts_title").html(item[2]).appendTo(td);
		td = $("<td>").appendTo(tr);
		$("<div>").addClass("posts_content").html(item[3]).appendTo(td);
		td = $("<td>").appendTo(tr);
		$("<div>").addClass("posts_description").html(item[4]).appendTo(td);
		var td = $("<td>").appendTo(tr );
		$("<button>").addClass("btn btn-xs btn-sm btn-primary mr-6 edit-item")
			.attr("data-id", item[0])
			.html("<i class='fa fa-edit'></i>").appendTo(td );
		$("<button>").addClass("btn btn-xs btn-sm btn-secondary delete-item")
			.attr("data-id", item[0])
			.html("<i class='fa fa-trash'></i>").appendTo(td );
	}
	table = $("#posts_table").DataTable();
	$('#posts_table tbody').on( 'click', 'tr', function () {
		if ( $(this).hasClass('selected') ) {
			$(this).removeClass('selected');
		}
		else {
		table.$('tr.selected').removeClass('selected');
		$(this).addClass('selected');
		}
	});
}
$(document).ready(function(){
});