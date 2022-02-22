base_url = "/plugins/plugin_product_catalog/interfaces/php/profiles.php";
upload_url = "/plugins/plugin_builder/include/classes/upload.php";
export_url = "/plugins/plugin_builder/include/classes/export_excel.php";
var table;
var sel_tr;
$(document).ready(function(){
	init_table();
	$("#profiles_new").on("click", new_record);
	$("#profiles_body").on("click", ".edit-item", edit_record );
	$("#profiles_body").on("click", ".delete-item", delete_record );
	$("#export_excel").on("click", export_excel );
	$("#save_record").on("click", save_record );
	$("body").on("click", ".ajax-file-upload-red", function(e){
		e.preventDefault(); 
		$(this).parent().parent().find("+ .btn").show();
		$(this).parent().parent().parent().find("div[data-type=file]").attr("data-file", "").show();
		$(this).parent().remove()
	});
	$("textarea").trumbowyg();
});
function export_excel(){
	$.ajax({
		url: export_url,
		data:{
			table: "profiles",
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
	var tr_name = $("#profiles_field_name").val();
	var tr_photo = $("#profiles_field_photo_upload").attr("data-file");
	var tr_bigo = $("#profiles_field_bigo").trumbowyg('html');
	$.ajax({
		url: base_url,
		data:{
			type: "save",
			id: id,
			name: tr_name,
			photo: tr_photo,
			bigo: tr_bigo,
		},
		type: "post",
		dataType: "json",
		success: function(data){
			if (data["status"] == "success" ){
				if (id == "-1"){
					var table_id = data["id"];
					table.row.add( ['<div class="profiles_name">' + tr_name + '</div>', 
					"<img width='100' data-file='tr_photo' class='profiles_photo' src='/plugins/uploads/" + tr_photo + "'>", 
					'<div class="profiles_bigo">' + tr_bigo + '</div>', 
					'<button class="btn btn-xs btn-sm btn-primary mr-6 edit-item" data-id="' + table_id + '"><i class="fa fa-edit"></i></button><button class="btn btn-xs btn-sm btn-secondary delete-item" data-id="'+ table_id + '"><i class="fa fa-trash"></i></button>']).draw( false );
				}else{
					$(sel_tr).find(".profiles_name").html(tr_name );
					$(sel_tr).find(".profiles_photo").html("<img width='100' data-file='tr_photo' src='/plugins/uploads/" + tr_photo + "'>");
					$(sel_tr).find(".profiles_bigo").html(tr_bigo );
				}
				$("#edit-modal").modal("hide");
			}
		}
	});
}
function new_record(){
	$("#edit-modal input").val("");
	$("textarea").trumbowyg("html", "");
	$(".ajax-file-upload-statusbar").remove();
	$("[data-type=file]").show();
	$("[data-type=file]").parent().find("button").show();
	$("#profiles_field_photo_btn").hide();
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
	$("#profiles_field_name").val($(sel_tr).find(".profiles_name").html());
	var img_file = $(sel_tr).find(".profiles_photo").attr("data-file");
	if (img_file && img_file != "" ){
		var container = $("#profiles_field_photo_upload + .ajax-file-upload-container");
		var status = $("<div>").addClass("ajax-file-upload-statusbar").appendTo(container );
		$("<img>").addClass("ajax-file-upload-file-img").attr("src", "/plugins/uploads/" + img_file ).appendTo(status);
		$("<div>").addClass("ajax-file-upload-red").text("Delete").appendTo(status );
		$("#profiles_field_photo_upload").attr("data-type", "file").attr("data-file", img_file);
		$("#profiles_field_photo_upload").hide();
		$("#profiles_field_photo_btn").hide();
	}
	
	$("#profiles_field_bigo").trumbowyg("html", $(sel_tr).find(".profiles_bigo").html());
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
	var parent = $("#profiles_body");
	for(var i = 0; i < data.length; i++ ){
		var item = data[i];
		var tr = $('<tr>').attr('data-id', item[0]).appendTo(parent );
		td = $("<td>").appendTo(tr);
		$("<div>").addClass("profiles_name").html(item[1]).appendTo(td);
		//$("<td>").text(item[1]).addClass("profiles_td_name").appendTo(tr);
		td = $("<td>").appendTo(tr);
		$("<img>").attr("width", "100").attr("data-file", item[2]).attr("src", "/plugins/uploads/" + item[2]).addClass("profiles_photo").appendTo(td);
		td = $("<td>").appendTo(tr);
		$("<div>").addClass("profiles_bigo").html(item[3]).appendTo(td);
		//$("<td>").text(item[3]).addClass("profiles_td_bigo").appendTo(tr);
		var td = $("<td>").appendTo(tr );
		$("<button>").addClass("btn btn-xs btn-sm btn-primary mr-6 edit-item")
			.attr("data-id", item[0])
			.html("<i class='fa fa-edit'></i>").appendTo(td );
		$("<button>").addClass("btn btn-xs btn-sm btn-secondary delete-item")
			.attr("data-id", item[0])
			.html("<i class='fa fa-trash'></i>").appendTo(td );
	}
	table = $("#profiles_table").DataTable();
	$('#profiles_table tbody').on( 'click', 'tr', function () {
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
	//$('.summernote').summernote();

	var extraObj = $("#profiles_field_photo_upload").uploadFile({
		url:upload_url, fileName:"apifile", autoSubmit:false,returnType:"json",onSuccess:function(files,data,xhr,pd){if (data["status"] == "success"){
			$("#profiles_field_photo_upload").attr("data-file", data["file"] );}else{$("#profiles_field_photo_upload").attr("data-file", "" );}}});
	$("#profiles_field_photo_btn").click(function(){extraObj.startUpload();});
});