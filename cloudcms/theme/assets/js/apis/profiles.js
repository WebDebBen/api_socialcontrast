base_url = "/plugins/plugin_product_catalog/interfaces/php/profiles.php";
var table;
var sel_tr;
$(document).ready(function(){
	init_table();
	$("#profiles_new").on("click", new_record);
	$("#profiles_body").on("click", ".edit-item", edit_record );
	$("#profiles_body").on("click", ".delete-item", delete_record );
	$("#save_record").on("click", save_record );
});
function save_record(){
	var id = $("#data-id").val();
	var tr_name = $("#profiles_field_name").val()
	var tr_photo = $("#profiles_field_photo").val()
	$.ajax({
		url: base_url,
		data:{
			type: "save",
			id: id,
			name: tr_name,
			photo: tr_photo,
		},
		type: "post",
		dataType: "json",
		success: function(data){
			if (data["status"] == "success" ){
				if (id == "-1"){
					var table_id = data["insert_id"];
					table.row.add( [tr_name, tr_photo, '<button class="btn btn-xs btn-sm btn-primary mr-6 edit-item" data-id="table_id"><i class="fa fa-edit"></i></button><button class="btn btn-xs btn-sm btn-secondary delete-item" data-id"table_id"><i class="fa fa-trash"></i></button>']).draw( false );
				}else{
					$("#profiles_table tr.selected").find(".profiles_td_name").text(tr_name );
					$("#profiles_table tr.selected").find(".profiles_td_photo").text(tr_photo );
				}
				$("#edit-modal").modal("hide");
			}
		}
	});
}
function new_record(){
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
	var id = $(this).attr('data-id');
	sel_tr = $(this).parent().parent();
	$("#data-id").val(id );
		$("#profiles_field_name").val($(sel_tr).find(".profiles_td_name").text());
		$("#profiles_field_photo").val($(sel_tr).find(".profiles_td_photo").text());$("#edit-modal").modal("show");
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
			$("<td>").text(item[1]).addClass("profiles_td_name").appendTo(tr);
			$("<td>").text(item[2]).addClass("profiles_td_photo").appendTo(tr);
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