base_url = "/plugins/plugin_product_catalog/interfaces/php/post_comment.php";
upload_url = "/plugins/plugin_builder/include/classes/upload.php";
export_url = "/plugins/plugin_builder/include/classes/export_excel.php";
var table;
var sel_tr;
$(document).ready(function(){
	init_table();
	$("#post_comment_new").on("click", new_record);
	$("#post_comment_body").on("click", ".edit-item", edit_record );
	$("#post_comment_body").on("click", ".delete-item", delete_record );
	$("#export_excel").on("click", export_excel );
	$("#save_record").on("click", save_record );
	$("body").on("click", ".ajax-file-upload-red", function(e){e.preventDefault(); $(this).parent().remove()});
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
			table: "post_comment",
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
	var tr_post_id = $("#post_comment_field_post_id").val();
	var tr_content = $("#post_comment_field_content").val();
	$.ajax({
		url: base_url,
		data:{
			type: "save",
			id: id,
			post_id: tr_post_id,
			content: tr_content,
		},
		type: "post",
		dataType: "json",
		success: function(data){
			if (data["status"] == "success" ){
				if (id == "-1"){
					var table_id = data["id"];
					table.row.add( ["<div class='post_comment_post_id'>" + tr_post_id + "</div>", "<div class='post_comment_content'>" + tr_content + "</div>", '<button class="btn btn-xs btn-sm btn-primary mr-6 edit-item" data-id="' + table_id + '"><i class="fa fa-edit"></i></button><button class="btn btn-xs btn-sm btn-secondary delete-item" data-id="'+ table_id + '"><i class="fa fa-trash"></i></button>']).draw( false );
				}else{
					$(sel_tr).find(".post_comment_post_id").html(tr_post_id );
					$(sel_tr).find(".post_comment_content").html(tr_content );
				}
				$("#edit-modal").modal("hide");
			}
		}
	});
}
function new_record(){
	$("#edit-modal input").val("");
	$(".ajax-file-upload-statusbar").remove();
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
	$("#post_comment_field_post_id").val($(sel_tr).find(".post_comment_post_id").html());
	$("#post_comment_field_content").val($(sel_tr).find(".post_comment_content").html());
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
	var parent = $("#post_comment_body");
	for(var i = 0; i < data.length; i++ ){
		var item = data[i];
		var tr = $('<tr>').attr('data-id', item[0]).appendTo(parent );
		td = $("<td>").appendTo(tr);
		$("<div>").addClass("post_comment_post_id").html(item[1]).appendTo(td);
		td = $("<td>").appendTo(tr);
		$("<div>").addClass("post_comment_content").html(item[2]).appendTo(td);
		var td = $("<td>").appendTo(tr );
		$("<button>").addClass("btn btn-xs btn-sm btn-primary mr-6 edit-item")
			.attr("data-id", item[0])
			.html("<i class='fa fa-edit'></i>").appendTo(td );
		$("<button>").addClass("btn btn-xs btn-sm btn-secondary delete-item")
			.attr("data-id", item[0])
			.html("<i class='fa fa-trash'></i>").appendTo(td );
	}
	table = $("#post_comment_table").DataTable();
	$('#post_comment_table tbody').on( 'click', 'tr', function () {
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