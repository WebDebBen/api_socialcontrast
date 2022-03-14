var dt_table;
$(document).ready(function(){
    load_dt_table_list();
    $("#dt_select_tb_btn").on("click", dt_select_datatable);
    $("#dt_table_data_new").on("click", dt_edit_table_new);
    $("#dt_save_record").on("click", dt_save_record);
});

function dt_save_record(){
    var inputs = $(".dt-edit-input");
    var records = {};
    for (var i = 0; i < inputs.length; i++){
        var input = inputs[i];
        var title = $(input).attr("data-fieldname");
        var value = $(input).val();
        records[title] = value;
    }
    records["id"] = $("#dt-data-id").val();
    
    $.ajax({
        url: "/plugins/plugin_builder/include/classes/plugin_datatable.php",
        data: {
            type: "save_table",
            id: $("#dt-data-id").val(),
            data: records
        },
        type: "post",
        dataType: "json",
        success: function(res ){
            console.log(res);
            // if (data["status"] == "success" ){
			// 	if (id == "-1"){
			// 		var table_id = data["id"];
			// 		table.row.add( ["<div class='aabbcc_ab'>" + tr_ab + "</div>", "<div class='aabbcc_cd'>" + tr_cd + "</div>", "<div class='aabbcc_ef'>" + tr_ef + "</div>", "<div class='aabbcc_gh'>" + tr_gh + "</div>", "<div class='aabbcc_ij'>" + tr_ij + "</div>", '<button class="btn btn-xs btn-sm btn-primary mr-6 edit-item" data-id="' + table_id + '"><i class="fa fa-edit"></i></button><button class="btn btn-xs btn-sm btn-secondary delete-item" data-id="'+ table_id + '"><i class="fa fa-trash"></i></button>']).draw( false );
			// 	}else{
			// 		$(sel_tr).find(".aabbcc_ab").html(tr_ab );
			// 		$(sel_tr).find(".aabbcc_cd").html(tr_cd );
			// 		$(sel_tr).find(".aabbcc_ef").html(tr_ef );
			// 		$(sel_tr).find(".aabbcc_gh").html(tr_gh );
			// 		$(sel_tr).find(".aabbcc_ij").html(tr_ij );
			// 	}
			// 	$("#edit-modal").modal("hide");
			// }
        }
    });
}

function dt_edit_table_new(){
    $("#data-dt-id").val("");
    $(".dt-edit-input").val("");
    $("#dt-edit-modal").modal("show");
}

function dt_select_datatable(){
    var table_name = $("#dt_tbname").val();
    var plugin_name = $("#plugin_name").val();

    $.ajax({
        url: "/plugins/plugin_builder/include/classes/plugin_datatable.php",
        data: {
            type: "table_info",
            table_name: table_name,
            plugin_name: plugin_name
        },
        type: "post",
        dataType: "json",
        success: function(res){
            if (res["status"] == "success"){
                init_dt_datatable(res["table_info"], res["json_data"], res["table_data"]);
            }
        }
    });
}

function get_dt_table_fields(table_columns, json_columns){
    var fields = [];
    if (!json_columns || json_columns.length == 0){
        for(var i = 0; i < table_columns.length; i++){
            var item = table_columns[i];
            var title = item["column_name"];
            if (item["column_key"] != "PRI" && title != "created_at" && title != "created_id" 
                    && title != "updated_at" && title != "updated_id" ){
                fields.push({title: title, is_edit: "true", is_show: " "});
            }
        }
    }else{
        for(var i = 0; i < table_columns.length; i++){
            var item = table_columns[i];
            var title = item["column_name"];
            var ref_table_name = item["referenced_table_name"];
            var ref_column_name = item["referenced_column_name"];

            if (item["column_key"] != "PRI" && title != "created_at" && title != "created_id" 
                    && title != "updated_at" && title != "updated_id" ){
                var tmp_item = {title: title, type: "varchar", is_edit: "true", is_show: "true",
                        ref_table_name: ref_table_name, ref_column_name: ref_column_name };

                var is_edit = "true";
                var is_show = "true";
                for(j = 0; j < json_columns.length; j++){
                    var json_item = json_columns[j];
                    if (json_item["title"] == title){
                        is_edit = json_item["editor_table"];
                        is_show = json_item["show_table"];
                        break;
                    }
                }

                tmp_item["is_edit"] = is_edit;
                tmp_item["is_show"] = is_show;
                tmp_item["type"] = item["data_type"];
                fields.push(tmp_item);
            }
        }
    }
    return fields;
}

function init_dt_datatable(table_info, json_data, table_data ){
    var json_columns = json_data["columns"];
    var table_columns = table_info["columns"];
    var fields_info = get_dt_table_fields(table_columns, json_columns);

    var table_wrap = $("#dt_table_wrap");
    $(table_wrap).html("");

    var table = $("<table>").attr("cellpadding", 0).attr("cellspacing", 0).addClass("display")
                .attr("id", "dt_table_data").attr("width", "100%").appendTo(table_wrap);
    var thead = $("<thead>").appendTo(table );    
    var thead_tr = $("<tr>").appendTo(thead);
    var tbody = $("<tbody>").attr("id", "dt_table_data_body").appendTo(table );

    for (var i = 0;i < fields_info.length; i++){
        var item = fields_info[i];
        var title = item["title"];
        if (item["is_show"] == "true"){
            $("<td>").text(title).appendTo(thead_tr);
        }
    }
    $("<td>").text("Action").appendTo(thead_tr);

    add_dt_filter_area(fields_info);
    add_dt_field_modal(fields_info);

    for (var i = 0; i < table_data.length; i++){
        var table_item = table_data[i];
        var tr = $("<tr>").appendTo(tbody);
        for (var j = 0; j < fields_info.length; j++ ){
            if (fields_info[j]["is_show"] == "true"){
                var field_title = fields_info[j]["title"];
                $("<td>").text(table_item[field_title]).appendTo(tr);
            }
        }
        var td = $("<td>").appendTo(tr );
		$("<button>").addClass("btn btn-xs btn-sm btn-primary mr-6 edit-item")
            .attr("type", "button")
			.attr("data-id", table_item["id"])
            .on("click", function(e){
                $("#dt-edit-modal").modal("show");
            })
			.html("<i class='fa fa-edit'></i> edit").appendTo(td );
		$("<button>").addClass("btn btn-xs btn-sm btn-secondary delete-item")
            .attr("type", "button")
			.attr("data-id", table_item["id"])
			.html("<i class='fa fa-trash'></i> delete").appendTo(td );
    }

    dt_table = $(table ).DataTable();
	$('#dt_table_data tbody').on( 'click', 'tr', function () {
		if ( $(this).hasClass('selected') ) {
			$(this).removeClass('selected');
		}
		else {
		    dt_table.$('tr.selected').removeClass('selected');
		    $(this).addClass('selected');
		}
	});
}

function add_dt_field_modal(fields){
    $("#dt_table_title_modal").val($("#dt_tbname").val() + " Table");
    var parent = $("#dt_edit_modal_body");
    $(parent).html("");

    for (var i = 0; i < fields.length; i++){
        var item = fields[i];
        var title = item["title"];
        var type = item["type"];
        var is_edit = item["is_edit"];
        var is_show = item["is_show"];
        var ref_table_name = item["ref_table_name"];
        var ref_column_name = item["ref_column_name"];

        if (is_edit == "true" ){
            var form_group = $("<div>").addClass("form-group row").appendTo(parent);
            $("<label>").addClass("col-sm-2 col-form-label text-right").text(title ).appendTo(form_group);
            var col_10 = $("<div>").addClass("col-sm-10").appendTo(form_group);
            if (ref_table_name && ref_table_name != "" ){
                $("<select>").addClass("form-control ref-select dt-edit-input")
                        .attr("data-reffield", ref_column_name)
                        .attr("data-fieldname", title)
                        .attr("data-reftable", ref_table_name).attr("data-type", "relation").appendTo(col_10);
            }else{
                switch(type){
                    case "enum":
                        $("<select>").addClass("form-control ref-select dt-edit-input").attr("data-reffield", ref_column_name)
                            .attr("data-fieldname", title)
                            .attr("data-reftable", ref_table_name).attr("data-type", "relation").appendTo(col_10);
                        break;
                    case "date": case "datetime": case "timestamp":
                        $("<input>").attr("type", "text").attr("data-fieldname", title)
                            .addClass("form-control dt_modal_datepicker dt-edit-input").appendTo(col_10);
                        break;
                    default:
                        $("<input>").attr("type", "text").attr("data-fieldname", title)
                            .addClass("form-control dt_modal_input dt-edit-input").appendTo(col_10);
                        break;
                }
            }
        }
    }
    $('.dt_modal_datepicker').datepicker({
        format: 'yyyy-mm-dd',
    });
}

function add_dt_filter_area(fields){
    var parent = $("#filter-wrap");
    $(parent).html("");

    var row = $("<div>").addClass("row").appendTo(parent);
    var index = 0;
    for (var i = 0;i < fields.length; i++){
        var item = fields[i];
        var type = item["type"];
        var title = item["title"];

        if (item["is_show"] == "true"){
            switch(type){
                case "enum":
                    var col = $("<div>").addClass("col-md-2").appendTo(row);
                    var form_group = $("<div>").addClass("form-group").appendTo(col);
                    $("<label>").text(title).appendTo(form_group);
                    $("<select>").addClass("form-control dt-search-item dt-search-item")
                        .attr("data-title", title)
                        .attr("data-index", index)
                        .attr("data-type", "enum")
                        .attr("id", "dt-search-item" + title ).appendTo(form_group);
                    break;
                case "date": case "datetime": case "timestamp":
                    var col = $("<div>").addClass("col-md-4").appendTo(row);
                    var tmp_row = $("<div>").addClass("row").appendTo(col);
                    var tmp_col = $("<div>").addClass("col-md-6").appendTo(tmp_row);
                    var form_group = $("<div>").addClass("form-group").appendTo(tmp_col);
                    $("<label>").text(title + " (From)").appendTo(form_group);
                    $("<input>").attr("type", "text")
                        .attr("data-title", title)
                        .attr("data-type", "date")
                        .attr("data-when", "from")
                        .attr("data-index", index)
                        .addClass("form-control dt-search-item datepicker").appendTo(form_group);

                    var tmp_col = $("<div>").addClass("col-md-6").appendTo(tmp_row);
                    form_group = $("<div>").addClass("form-group").appendTo(tmp_col);
                    $("<label>").text(title + " (To)").appendTo(form_group);
                    $("<input>").attr("type", "text")
                        .attr("data-title", title)
                        .attr("data-type", "date")
                        .attr("data-when", "to")
                        .attr("data-index", index)
                        .addClass("form-control dt-search-item datepicker").appendTo(form_group);
                    break;
                default:
                    var col = $("<div>").addClass("col-md-2").appendTo(row);
                    var form_group = $("<div>").addClass("form-group").appendTo(col);
                    $("<label>").text(title).appendTo(form_group);
                    $("<input>").addClass("form-control dt-search-item")
                        .attr("data-title", title)
                        .attr("data-type", "text")
                        .attr("data-index", index)
                        .attr("id", "dt-search-item" + title ).appendTo(form_group);
                    break;
            }
            index++;
        }
    }

    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
    });

    $.fn.dataTable.ext.search.push(
        function(settings, data, dataIndex) {
            var filters = $(".dt-search-item");
            var flag = true;
            for(var i = 0; i < filters.length; i++ ){
                var item = filters[i];
                var type = $(item).attr("data-type");
                var index = $(item).attr("data-index");
                var when = $(item).attr("data-when");

                if (type == "text"){
                    var val = $(item).val();
                    if (val != "" && data[index].indexOf(val) < 0 ){
                        flag = false;
                    }
                }else if(type == "enum"){
                    var val = $(item).find("option:selected").text();
                    if (val != "" && data[index] == val ){
                        flag = false;
                    }
                }else if(type == "date" && when == "from"){
                    var table_date = data[index];
                    var min = $(item).val();
                    min = min == "" ? "1900-01-01" : min;
                    min = min.substr(0, 10);
                    if (!moment(table_date).isSameOrAfter(min)){
                        flag = false;
                    }
                }else if(type == "date" && when == "to"){
                    var table_date = data[index];
                    var max = $(item).val();
                    max = max == "" ? "2100-01-01" : max;
                    max = max.substr(0, 10);
                    if (!moment(table_date).isSameOrBefore(max)){
                        flag = false;
                    }
                }

                if (flag == false) break;
            }
            return flag;
    });

    $('.dt-search-item').change(function() {
        dt_table.draw();
    });

    $('.dt-search-item').on("keyup", function() {
        dt_table.draw();
    });
}

function load_dt_table_list(){
    $.ajax({
        url: "/plugins/plugin_builder/include/classes/plugin_datatable.php",
        data: {
            type: "table_list",
        },
        type: "post",
        dataType: "json",
        success: function(res ){
            if (res["status"] == "success"){
                init_dt_table_list(res["data"]);
            }
        }
    });
}

function init_dt_table_list(data){
    if (data.length < 1) return;

    var select = $("#dt_tbname");
    for (var i = 0;i < data.length; i++){
        var item = data[i];
        $("<option>").attr("value", item).text(item).appendTo(select);
    }
}