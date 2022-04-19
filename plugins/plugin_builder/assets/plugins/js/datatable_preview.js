var dtp_datatable_info;
var g_dpt_datatable;

$(document).ready(function(){
    init_dtp_datatablelist();
    $("#dtp_datatable_list").on("change", init_dtp_datatable_info);
    $("#dtp_generate_table").on("click", dtp_generate_table);
    $("#add-dtp-btn").on("click", add_dtp_datatable_new);
});

function add_dtp_datatable_new(){
    $("#data-dtp-id").val("");
    $(".dtp-edit-input").val("");
    $("#dtp-edit-modal").modal("show");
}

function dtp_generate_table(){
    generate_dtp_php();
    generate_dtp_datatable();
}

function generate_dtp_datatable(){
    var columns = dtp_datatable_info["columns"];

    var parent = $("#dtp_datatable_area");
    $(parent).html("");

    var table = $("<table>").addClass("table table-bordered table-striped").appendTo(parent);
    var th = $("<thead>").appendTo(table);
    var tr = $("<tr>").appendTo(th);
    for (var i = 0; i < columns.length; i++){
        var item = columns[i];
        var column_name = item["column_name"];
        if (item["visible"] == "true"){
            if (column_name != "created_id" && column_name != "created_at" && column_name != "updated_at" && column_name != "updated_id"){
                $("<th>").text(column_name).appendTo(tr);
            }
        }
    }
    $("<th>").text("Action").appendTo(tr);
    var tbody = $("<tbody>").appendTo(table);
    
    g_dpt_datatable = $(table).DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    });
    g_dpt_datatable.buttons().container().appendTo($('#dtp_datatable_area .dataTables_wrapper > .row .col-md-6:nth-child(1)'));
    add_dtp_datatable_data(tbody);
}

function add_dtp_datatable_data(tbody){
    var plugin_name = $("#plugin_name").val();
    var columns = dtp_datatable_info["columns"];
    $.ajax({
        url: "/plugins/" + plugin_name + "/include/classes/plugin_datatable_preview.php",
        data:{
            type: "load_datatable_data",
            table_name: $("#dtp_generate_table").attr("data-table")
        },
        type: "post",
        dataType: "json",
        success: function(data){
            for (var i = 0; i<data.length; i++){
                var rs = [];
                var item = data[i];
                for (var j = 0; j < columns.length; j++){
                    var col = columns[j];
                    var column_name = col["column_name"];
                    if (col["visible"] == "true"){
                        if (column_name != "created_id" && column_name != "created_at" && column_name != "updated_at" && column_name != "updated_id"){
                            rs.push(item[column_name] ? item[column_name] : "");
                        }
                    }
                }
                var table_id = item["id"];
                rs.push('<button type="button" class="btn btn-xs btn-sm btn-primary mr-6 edit-item" data-id="' + table_id + '"><i class="fa fa-edit"></i>edit</button><button type="button" class="btn btn-xs btn-sm btn-secondary delete-item" data-id="'+ table_id + '"><i class="fa fa-trash"></i>delete</button>');
                g_dpt_datatable.row.add(rs).draw(false);
                $("#dtp_datatable_area .edit-item").on("click", edit_dtp_modal);
            }
        }
    });
}

function edit_dtp_modal(){
    var table_id = $(this).attr("data-id");
    $("#data-dtp-id").val(table_id);
    var plugin_name = $("#plugin_name").val();
    $.ajax({
        url: "/plugins/" + plugin_name + "/include/classes/plugin_datatable_preview.php",
        data: {
            type: "load_data",
            id: table_id,
            table_name: dtp_datatable_info["table_name"]
        },
        type: "post",
        dataType: "json",
        success: function(res ){
            var data = res["data"];
            for (var i = 0; i < dtp_datatable_info["columns"].length; i++){
                var item = dtp_datatable_info["columns"][i];
                $(".dtp-edit-modal-" + item['column_name']).val(data[item['column_name']]);
            }
            
        }
    });
    $("#dtp-edit-modal").modal("show");
}

function generate_dtp_php(){
    var plugin_name = $("#plugin_name").val();
    var datatable_name = $("#dtp_datatable_list").val();
    var is_allow = $("#dtp_allow_add_chk").is(":checked");
    var is_edit = $("#dtp_allow_edit_chk").is(":checked");
    var is_delete = $("#dtp_allow_delete_chk").is(":checked");
    var is_export = $("#dtp_allow_export_chk").is(":checked");
    var is_adv_search = $("#dtp_allow_advanced_search_chk").is(":checked");
    var endln = "\n";
    var str = "$item = new Datatable($db)";
    str += endln + "$item->plugin_name='" + plugin_name + "'";
    str += endln + "$item->datatable_name='" + datatable_name + "'";
    str += endln + "$item->allow_add = " + is_allow;
    str += endln + "$item->allow_edit = " + is_edit;
    str += endln + "$item->allow_delete = " + is_delete;
    str += endln + "$item->allow_advanced_search_form = " + is_adv_search;
    str += endln + "$item->allow_export = " + is_export;
    str += endln + "$item->add_edit_form = 'add_edit_form'";
    str += endln + "$item->conditions();";
    str += endln + "$item->createDatatable();";

    $("#dtp_datatable_php").html(str);
}

function init_dtp_datatablelist(){
    var plugin_name = $("#plugin_name").val();
    $.ajax({
        url: "/plugins/" + plugin_name + "/include/classes/plugin_datatable_preview.php",
        data:{
            type: "datatable_list",
            plugin_name: plugin_name
        },
        type: "post",
        dataType: "json",
        success: function(data){
            var parent = $("#dtp_datatable_list");
            $(parent).html("");
            var tables = data["list"];
            for (var i = 0; i < tables.length; i++){
                var item = tables[i];
                $("<option>").text(item).attr("value", item).appendTo(parent);
            }
            init_dtp_datatable_info();
        }
    });
}

function init_dtp_datatable_info(){
    var plugin_name = $("#plugin_name").val();
    var table_name = $("#dtp_datatable_list").val();
    $.ajax({
        url: "/plugins/" + plugin_name + "/include/classes/plugin_datatable_preview.php",
        data:{
            type: "datatable_info",
            plugin_name: plugin_name,
            table_name: table_name
        },
        type: "post",
        dataType: "json",
        success: function(data){
            dtp_datatable_info = data;
            var table_name = data["table_name"];
            var datatable_name=  data["datatable_name"];
            var columns = data["columns"];
            $("#dtp_generate_table").attr("data-table", table_name);
            var hidden_parent = $("#dtp_hidden_columns");
            var search_parent = $("#dtp_adbanced_search_select");
            var add_edit_parent = $("#dtp_add_edit_select");
            $(hidden_parent).html("");
            $(search_parent).html("");
            $(add_edit_parent).html("");

            for (var i = 0; i < columns.length; i++){
                var item = columns[i];
                var column_name = item["column_name"];
                
                if (item["visible"] == "false"){
                    $("<option>").attr("value", column_name).attr("selected", true).text("column_name").appendTo(hidden_parent);
                }else{
                    $("<option>").attr("value", column_name).text(column_name).appendTo(hidden_parent);
                }

                if (item["show_search"] == "true"){
                    $("<option>").attr("value", column_name).text(column_name).attr("selected", true).appendTo(search_parent);
                }else{
                    $("<option>").attr("value", column_name).text(column_name).appendTo(search_parent);
                }

                $("<option>").attr("value", column_name).text(column_name + "(" + item["column_default"] + ")").appendTo(add_edit_parent);
            }
            add_dtn_filter_area();
            add_dtp_field_modal();

            if ($(hidden_parent).parent().hasClass("multiselect-native-select")){
                 $(hidden_parent).parent().parent().html($(hidden_parent).clone())
            }

            if ($(search_parent).parent().hasClass("multiselect-native-select")){
                $(search_parent).parent().parent().html($(search_parent).clone())
            }

            if ($(add_edit_parent).parent().hasClass("multiselect-native-select")){
                $(add_edit_parent).parent().parent().html($(add_edit_parent).clone())
            }

            $("#dtp_hidden_columns").multiselect({
                enableClickableOptGroups: true,
                includeSelectAllOption:true,
                nonSelectedText: 'Select language'
            });

            $("#dtp_adbanced_search_select").multiselect({
                enableClickableOptGroups: true,
                includeSelectAllOption:true,
                nonSelectedText: 'Select language'
            });

            $("#dtp_add_edit_select").multiselect({
                enableClickableOptGroups: true,
                includeSelectAllOption:true,
                nonSelectedText: 'Select language'
            });
        }
    });
}

function add_dtn_filter_area(){
    var columns = dtp_datatable_info["columns"]
    var parent = $("#dtp-filter-wrap");
    $(parent).html("");

    var row = $("<div>").addClass("row").appendTo(parent);
    var index = 0;
    for (var i = 0;i < columns.length; i++){
        var item = columns[i];
        var type = item["data_type"];
        var title = item["column_name"];

        if (item["show_search"] == "true"){
            switch(type){
                case "enum":
                    var col = $("<div>").addClass("col-md-2").appendTo(row);
                    var form_group = $("<div>").addClass("form-group").appendTo(col);
                    $("<label>").text(title).appendTo(form_group);
                    $("<select>").addClass("form-control dtn-search-item dtn-search-item")
                        .attr("data-title", title)
                        .attr("data-index", index)
                        .attr("data-type", "enum")
                        .attr("id", "dtn-search-item" + title ).appendTo(form_group);
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
                        .addClass("form-control dtn-search-item datepicker").appendTo(form_group);

                    var tmp_col = $("<div>").addClass("col-md-6").appendTo(tmp_row);
                    form_group = $("<div>").addClass("form-group").appendTo(tmp_col);
                    $("<label>").text(title + " (To)").appendTo(form_group);
                    $("<input>").attr("type", "text")
                        .attr("data-title", title)
                        .attr("data-type", "date")
                        .attr("data-when", "to")
                        .attr("data-index", index)
                        .addClass("form-control dtn-search-item datepicker").appendTo(form_group);
                    break;
                default:
                    var col = $("<div>").addClass("col-md-2").appendTo(row);
                    var form_group = $("<div>").addClass("form-group").appendTo(col);
                    $("<label>").text(title).appendTo(form_group);
                    $("<input>").addClass("form-control dtn-search-item")
                        .attr("data-title", title)
                        .attr("data-type", "text")
                        .attr("data-index", index)
                        .attr("id", "dtn-search-item" + title ).appendTo(form_group);
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
            var filters = $(".dtn-search-item");
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

    $('.dtn-search-item').change(function() {
        g_dpt_datatable.draw();
    });

    $('.dtn-search-item').on("keyup", function() {
        g_dpt_datatable.draw();
    });
}

function add_dtp_field_modal(){
    var fields = dtp_datatable_info["columns"];
    $("#dtp_table_title_modal").val(dtp_datatable_info["table_name"] + " Table");
    var parent = $("#dtp_edit_modal_body");
    $(parent).html("");

    for (var i = 0; i < fields.length; i++){
        var item = fields[i];
        var title = item["column_name"];
        var type = item["data_type"];
        //var ref_table_name = item["ref_table_name"];
        //var ref_column_name = item["ref_column_name"];
        var form_group = $("<div>").addClass("form-group row").appendTo(parent);
        $("<label>").addClass("col-sm-2 col-form-label text-right").text(title ).appendTo(form_group);
        var col_10 = $("<div>").addClass("col-sm-10").appendTo(form_group);
        //if (ref_table_name && ref_table_name != "" ){
        //    var tmp_select = $("<select>").addClass("form-control ref-select dt-edit-input dt-edit-modal-" + title)
        //            .attr("data-reffield", ref_column_name)
        //            .attr("data-fieldname", title)
        //            .attr("data-reftable", ref_table_name).attr("data-type", "relation").appendTo(col_10);
        //    load_relation_table_data(tmp_select, $("#dt_tbname").val(), title, ref_table_name, ref_column_name);
        //}else{
            switch(type){
                case "enum":
                    $("<select>").addClass("form-control ref-select dtp-edit-input dtp-edit-modal-" + title)
                        .attr("data-reffield", ref_column_name)
                        .attr("data-fieldname", title)
                        .attr("data-reftable", ref_table_name).attr("data-type", "relation").appendTo(col_10);
                    break;
                case "date": case "datetime": case "timestamp":
                    $("<input>").attr("type", "text").attr("data-fieldname", title)
                        .addClass("form-control dtp_modal_datepicker dtp-edit-input dtp-edit-modal-" + title)
                        .appendTo(col_10);
                    break;
                default:
                    $("<input>").attr("type", "text").attr("data-fieldname", title)
                        .addClass("form-control dtp_modal_input dtp-edit-input dtp-edit-modal-" + title)
                        .appendTo(col_10);
                    break;
            }
    }
    $('.dtp_modal_datepicker').datepicker({
        format: 'yyyy-mm-dd',
    });
}
