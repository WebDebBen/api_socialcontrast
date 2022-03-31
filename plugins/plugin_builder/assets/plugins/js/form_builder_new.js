var controls = [
  {
    id: "text_obj",
    property: "<form class='form'>" +
      "<div class='form-group col-md-12'>" +
        "<label class='control-label'>Text Name</label> <input class='form-control' type='text' name='name' id='name'>" +
        "<label class='control-label'>Label Text</label> <input class='form-control' type='text' name='label' id='label'>" +
        "<label class='control-label'>Placeholder</label> <input type='text' name='placeholder' id='placeholder' class='form-control'>" +
        "<hr/>" +
        "<button class='btn btn-info save_data'>Save</button><button class='btn btn-danger del_data'>Delete</button>" +
      "</div>" +
    "</form>",
    element: "<label class='col-md-12 control-label valtype' for='input01' data-valtype='label'>Text input</label>" +
          "<div class='col-md-12'>" +
            "<input type='text' placeholder='placeholder' class='form-control input-md valtype' data-valtype='placeholder' >" +
          "</div>",
  },
  {
    id: "textarea_obj",
    property: "<form class='form'>" + 
                "<div class='form-group col-md-12'>" + 
                  "<label class='control-label'>TextArea Name</label> <input class='form-control' type='text' name='name' id='name'>" +
                  "<label class='control-label'>Label Text</label> <input class='form-control' type='text' name='label' id='label'>" + 
                  "<hr/>" + 
                  "<button class='btn btn-info save_data'>Save</button><button class='btn btn-danger del_data'>Delete</button>" + 
                "</div>" + 
              "</form>",
    element: "<label class='col-md-12 control-label valtype' data-valtype='label'>Textarea</label>" +
              "<div class='col-md-12'>" +
                "<div class='textarea'>" +
                  "<textarea class='form-control valtype' data-valtype='textarea' /> </textarea>" +
                "</div>" +
              "</div>"
  },
  {
    id: "ckeditor_obj",
    property: "<form class='form'" +
                "<div class='form-group col-md-12'>" +
                  "<label class='control-label'>Editor</label> <input class='form-control' type='text' name='name' id='name'>" +
                  "<label class='control-label'>Label Text</label> <input class='form-control' type='text' name='label' id='label'>" +
                  "<hr/>" +
                  "<button class='btn btn-info save_data'>Save</button><button class='btn btn-danger del_data'>Delete</button>" +
                "</div>" +
              "</form>",
    element: "<label class='col-md-12 control-label valtype' data-valtype='label'>Editor</label>" +
              "<div class='col-md-12'>" +
                "<div class='ck-editor'><img src='assets/images/wyg.png' style='width:100%'></div>" +
              "</div>" +
            "</div>"
  },
  {
    id: "date_obj",
    property: "<form class='form'" +
                "<div class='form-group col-md-12'>" +
                  "<label class='control-label'>Date</label> <input class='form-control' type='text' name='name' id='name'>" +
                  "<label class='control-label'>Label Text</label> <input class='form-control' type='text' name='label' id='label'>" +
                  "<hr/>" +
                  "<button class='btn btn-info save_data'>Save</button><button class='btn btn-danger del_data'>Delete</button>" +
                "</div>" +
              "</form>",
    element: "<label class='col-md-12 control-label valtype' data-valtype='label'>Date</label>" +
              "<div class='col-md-12'>" +
                "<div class='input-group date' data-target-input='nearest'>" +
                    "<input type='text' class='form-control datetimepicker-input' />" +
                    "<div class='input-group-append' data-toggle='datetimepicker'>" +
                      "<div class='input-group-text'><i class='fa fa-calendar'></i></div>" +
                    "</div>" +
                  "</div>" +
              "</div>" +
            "</div>"
  },
  {
    id: "file_obj",
    property:"<form class='form'" +
                "<div class='form-group col-md-12'>" +
                  "<label class='control-label'>File</label> <input class='form-control' type='text' name='name' id='name'>" +
                  "<label class='control-label'>Label Text</label> <input class='form-control' type='text' name='label' id='label'>" +
                  "<hr/>" +
                  "<button class='btn btn-info save_data'>Save</button><button class='btn btn-danger del_data'>Delete</button>" +
                "</div>" +
              "</form>",
    element: "<label class='col-md-12 control-label valtype' for='input01' data-valtype='label'>File</label>" +
              "<div class='col-md-12'>" +
                "<input type='file' disable placeholder='placeholder' class='form-control input-md valtype' data-valtype='placeholder' >" +
              "</div>",
  },
  {
    id: "paragraph_obj",
    property:"<form class='form'" +
                "<div class='form-group col-md-12'>" +
                  "<label class='control-label'>Paragraph Text</label> <input class='form-control' type='text' name='text' id='text'>" +
                  "<select class='form-control mt-1r' id='paragraph-select'>" +
                    "<option value='h1'>H1</option>" +
                    "<option value='h2'>H2</option>" +
                    "<option value='h3'>H3</option>" +
                    "<option value='h4'>H4</option>" +
                    "<option value='h5'>H5</option>" +
                    "<option value='h6'>H6</option>" +
                  "</select>" +
                  "<hr/>" +
                  "<button class='btn btn-info save_data'>Save</button><button class='btn btn-danger del_data'>Delete</button>" +
                "</div>" +
              "</form>",
    element: "<label class='col-md-12 control-label valtype paragraph-text' data-valtype='paragraph'><h1>Paragraph</h1></label>"
  },
  {
    id: "image_obj",
    property:"<form class='form'" +
                "<div class='form-group col-md-12'>" +
                  "<label class='control-label'>Image</label> <input class='form-control' type='text' name='name' id='name'>" +
                  "<label class='control-label'>Label Text</label> <input class='form-control' type='text' name='label' id='label'>" +
                  "<hr/>" +
                  "<button class='btn btn-info save_data'>Save</button><button class='btn btn-danger del_data'>Delete</button>" +
                "</div>" +
              "</form>",
    element: "<label class='col-md-12 control-label valtype' for='input01' data-valtype='label'>Image</label>" +
              "<div class='col-md-12'>" +
                "<input type='file' disable placeholder='placeholder' class='form-control input-md valtype' data-valtype='placeholder' >" +
              "</div>",
  },
  {
    id: "hidden_obj",
    property: "<form class='form'>" +
      "<div class='form-group col-md-12'>" +
        "<label class='control-label'>Hidden Name</label> <input class='form-control' type='text' name='name' id='name'>" +
        "<label class='control-label'>Label Text</label> <input class='form-control' type='text' name='label' id='label'>" +
        "<label class='control-label'>Placeholder</label> <input type='text' name='placeholder' id='placeholder' class='form-control'>" +
        "<hr/>" +
        "<button class='btn btn-info save_data'>Save</button><button class='btn btn-danger del_data'>Delete</button>" +
      "</div>" +
    "</form>",
    element: "<label class='col-md-12 control-label valtype' for='input01' data-valtype='label'>Hidden input</label>" +
          "<div class='col-md-12'>" +
            "<input type='text' placeholder='placeholder' class='form-control input-md valtype' data-valtype='placeholder' >" +
          "</div>",
  },
  {
    id: "select_obj",
    property: "<form class='form'>" +
                "<div class='form-group col-md-12'>" +
                "<label class='control-label'>Select Name</label> <input class='form-control' type='text' name='name' id='name'>" +
                "<label class='control-label'>Label Text</label> <input class='form-control mb-2r' type='text' name='label' id='label'>" +
                "<div class='options_wrap' id='select_obj_wrap'></div>" +
                "<hr/>" +
                "<button class='btn btn-success add_select_item' type='button'>Add</button><button class='btn btn-info save_data' type='button'>Save</button><button class='btn btn-danger del_data'>Delete</button>" +
                "</div>" +
              "</form>",
    element: '<label class="col-md-12 control-label valtype" data-valtype="label">Select - Basic</label>' + 
              '<div class="col-md-12">' + 
                '<select class="form-control input-md valtype" data-valtype="option">' + 
                  '<option value="option_1">Option 1</option>' + 
                  '<option value="option_2">Option 2</option>' + 
                  '<option value="option_3">Option 3</option>' + 
                '</select>' + 
              '</div>'
  },
  {
    id: 'checkbox_obj',
    property: "<form class='form'>" +
                "<div class='form-group col-md-12'>" +
                "<label class='control-label'>Checkbox Group Name</label> <input class='form-control' type='text' name='name' id='name'>" +
                "<label class='control-label'>Label Text</label> <input class='form-control mb-2r' type='text' name='label' id='label'>" +
                "<div class='options_wrap' id='checkbox_obj_wrap'></div>" +
                "<hr/>" +
                "<button class='btn btn-success add_check_item' type='button'>Add</button><button class='btn btn-info save_data' type='button'>Save</button><button class='btn btn-danger del_data'>Delete</button>" +
                "</div>" +
              "</form>",
    element: '<label class="col-md-12 control-label valtype" data-valtype="label">Checkboxes</label>' +
              '<div class="col-md-12 checkbox_wrap valtype" data-valtype="checkboxes">' +
                '<label class="checkbox">' +
                  '<input type="checkbox" value="check_1">' +
                  'Checkbox' +
                '</label>' +
                '<label class="checkbox">' +
                  '<input type="checkbox" value="check_2">' +
                  'Checkbox' +
                '</label>' +
              '</div>'
  },
  {
    id: "radio_obj",
    property: "<form class='form'>" +
                "<div class='form-group col-md-12'>" +
                  "<label class='control-label'>Radio Group Name</label> <input class='form-control' type='text' name='name' id='name'>" +
                  "<label class='control-label'>Label Text</label> <input class='form-control mb-2r' type='text' name='label' id='label'>" +
                  "<div class='options_wrap' id='radio_obj_wrap'></div>" +
                  "<hr/>" +
                  "<button class='btn btn-success add_radio_item' type='button'>Add</button><button class='btn btn-info save_data' type='button'>Save</button><button class='btn btn-danger del_data'>Delete</button>" +
                  "</div>" +
              "</form>",
    element: '<label class="col-md-12 control-label valtype" data-valtype="label">Radio buttons</label>' +
              '<div class="col-md-12 valtype radio_wrap" data-valtype="radios">' +
                '<label class="radio">' +
                  '<input type="radio" value="Option" name="radio" value="radio_1">' +
                  'Option one' +
                '</label>' +
                '<label class="radio">' +
                  '<input type="radio" value="Option" name="radio" value="radio_2">' +
                  'Option two' +
                '</label>' +
              '</div>'
  },
  {
    id: "condition_start",
    property: "<form class='form'>" +
              "<div class='form-group col-md-12'>" +
                "<div id='condition_start_wrap'>" +
                  "<label class='label-control'>Parent Field</label>" +
                  "<select class='form-control' id='cond_start_select'><select>" +
                  "<label class='label-control'>Parent Value</label>" +
                  "<input type='text' class='form-control' id='cond_start_value'>" +
                "</div><hr>" + 
                "<button class='btn btn-info save_data' type='button'>Save</button><button class='btn btn-danger del_data'>Delete</button>" +
              "</div>" +
            "</form>",
    element: "<div class='condition-wrap action-start'>Condition Start</div>",
  },
  {
    id: "condition_end",
    property: "<form class='form'>" +
              "<div class='form-group col-md-12'>" +
                "<div class='condition-wrap action-end'><span>Condition end</span></div>" +
                "<hr><button class='btn btn-info save_data' type='button'>Save</button><button class='btn btn-danger del_data'>Delete</button>" +
              "</div>" +
            "</form>",
    element: "<div class='condition-wrap action-end'><span>Condition end</span></div>"
  },
];

var prev_obj = "";
var plugin_name = $("#plugin_name").val();
var upload_url = "/plugins/" + plugin_name + "/include/classes/upload.php";

$(document).ready(function(){
  $("#accor_left").on("click", accor_action );
  $("#accor_right").on("click", accor_action );

  new Sortable(document.getElementById("target_fieldset"), {
    handle: '.form-component',
    animation: 150,
    ghostClass: 'blue-background-class'
  });

  $("#preview_form").on("click", function(pr){
    var parent = $("#priview_wrap");
    $(parent).html("");
    var json_obj = get_json_data();
    var cond_index = 1;
    var cond_info = [];
    var cond_flag = false;
    for (var i = 0; i < json_obj.length; i++ ){
      var item = json_obj[i];
      switch(item["data_id"]){
        case "text_obj":
          var form_comp = $("<div>").attr("class", "row mb-1r form preivew-component")
                      .attr("data-flag", cond_flag )
                      .attr("data-condind", cond_index ).appendTo(parent);
          $("<label>").addClass("col-md-2 text-right")
                            .text(item["label"] ).appendTo(form_comp );
          var col = $("<div>").addClass("col-md-10").appendTo(form_comp );
          $("<input>").attr("type", "text").attr("placeholder", item["placeholder"])
            .attr("data-condind", cond_index )
            .addClass("form-control input-md " + item["data_name"]).appendTo(col );
          break;

        case "textarea_obj":
          var form_comp = $("<div>").attr("class", "row mb-1r form preivew-component").attr("data-flag", cond_flag )
              .attr("data-condind", cond_index ).appendTo(parent);
          $("<label>").addClass("col-md-2 control-label text-right")
              .text(item["label"] ).appendTo(form_comp );
          var col = $("<div>").addClass("col-md-10").appendTo(form_comp );
          $("<textarea>").attr("type", "text").attr("data-condind", cond_index )
              .addClass("form-control input-md " + item["data_name"]).appendTo(col );
          break;

        case "ckeditor_obj":
          var form_comp = $("<div>").attr("class", "row mb-1r form preivew-component").attr("data-flag", cond_flag )
              .attr("data-condind", cond_index ).appendTo(parent);
          $("<label>").addClass("col-md-2 control-label text-right")
              .text(item["label"] ).appendTo(form_comp );
          var col = $("<div>").addClass("col-md-10").appendTo(form_comp );
          var editor = $("<textarea>").attr("data-condind", cond_index )
              .addClass("form-control ckeditor-obj " + item["data_name"]).appendTo(col );
          $(editor).trumbowyg();
          break;

        case "file_obj":
          var form_comp = $("<div>").attr("class", "row mb-1r form preivew-component").attr("data-flag", cond_flag )
              .attr("data-condind", cond_index ).appendTo(parent);
          $("<label>").addClass("col-md-2 control-label text-right")
              .text(item["label"] ).appendTo(form_comp );
          var col = $("<div>").addClass("col-md-10").appendTo(form_comp );
          var editor = $("<div>").attr("data-condind", cond_index )
              .addClass("file-upload-div file-obj " + item["data_name"]).appendTo(col );
          $(editor).uploadFile({url:upload_url, fileName:"apifile", showCancel: true, showDelete: true, autoSubmit:true, returnType:"json"});
          break;

        case "image_obj":
          var form_comp = $("<div>").attr("class", "row mb-1r form preivew-component").attr("data-flag", cond_flag )
              .attr("data-condind", cond_index ).appendTo(parent);
          $("<label>").addClass("col-md-2 control-label text-right")
              .text(item["label"] ).appendTo(form_comp );
          var col = $("<div>").addClass("col-md-10").appendTo(form_comp );
          var editor = $("<div>").attr("data-condind", cond_index )
              .addClass("file-upload-div file-obj " + item["data_name"]).appendTo(col );
          $(editor).uploadFile({
            url:upload_url, fileName:"apifile", autoSubmit:true, returnType:"json",showPreview: true,
            showCancel: true, showDelete: true,
          onSuccess:function(files,data,xhr,pd){
            if (data["status"] == "success"){
              $("#tmp_file_upload").attr("data-file", data["file"] );
            }else{
              $("#tmp_file_upload").attr("data-file", "" );
            }
          }});
          break;

        case "hidden_obj":
          break;
        case "paragraph_obj":
          var form_comp = $("<div>").attr("class", "row mb-1r form preivew-component").attr("data-flag", cond_flag )
              .attr("data-condind", cond_index ).appendTo(parent);
          $("<" + item["tag_name"] +">").addClass("col-md-12")
              .text(item["text"] ).appendTo(form_comp );
          break;

        case "date_obj":
          var form_comp = $("<div>").attr("class", "row mb-1r form preview-component")
                    .attr("data-flag", cond_flag )
                    .attr("data-condind", cond_index ).appendTo(parent );
          $("<label>").addClass("col-md-2 control-label text-right")
                    .text(item["label"] ).appendTo(form_comp );
          var col = $("<div>").addClass("col-md-10").appendTo(form_comp );
          var obj = $("<div>").addClass("input-group date valtype")
                    .attr("data-valtype", "date")
                    .attr("data-target-input", "nearest").appendTo(col );
          $("<input>").attr("type", "text")
                    .attr("data-condind", cond_index)
                    .addClass("form-control datetimepicker-input date-obj " + item["data_name"]).appendTo(obj );
          var div = $("<div>").addClass("input-group-append").attr("data-toggle", "datetimepicker")
                    .appendTo(obj );
          $("<div>").addClass("input-group-text").html("<i class='fa fa-calendar'></i>").appendTo(div );
          $(obj).datepicker();
          break;

        case "select_obj":
          var form_comp = $("<div>").attr("class", "row mb-1r form preivew-component").attr("data-flag", cond_flag )
            .attr("data-condind", cond_index ).appendTo(parent);
          $("<label>").addClass("col-md-2 control-label text-right")
            .text(item["label"] ).appendTo(form_comp );
          var col = $("<div>").addClass("col-md-10").appendTo(form_comp );
          var select = $("<select>").addClass("form-control input-md " + item["data_name"])
            .attr("data-condind", cond_index ).appendTo(col );
          for (var j = 0; j < item["option_values"].length; j++ ){
            var a = item["option_values"][j];
            $("<option>").attr("value", a["value"]).text(a["text"]).appendTo(select );
          }
          break;

        case "radio_obj":
          var form_comp = $("<div>").attr("class", "row mb-1r form preivew-component").attr("data-flag", cond_flag )
            .attr("data-cond", cond_index ).appendTo(parent);
          $("<label>").addClass("col-md-2 control-label text-right")
            .text(item["label"] ).appendTo(form_comp );
          var col = $("<div>").addClass("col-md-10").appendTo(form_comp );
          if (item["radio_labels"]){
            for (var j = 0; j < item["radio_labels"].length; j++ ){
              var a = item["radio_labels"][j];
              var label  = $("<label>").addClass("radio").text(a['text']).appendTo(col );
              $("<input>").attr("type", "radio").addClass("form_control " + item["data_name"])
                .val(a["value"]).attr("name", "radio" + item["id"])
                .attr("data-name", item["data_name"])
                .attr("data-condid", cond_index).appendTo(label );
            }
          }
          break;

        case "checkbox_obj":
          var form_comp = $("<div>").attr("class", "row mb-1r form preivew-component").attr("data-flag", cond_flag )
            .attr("data-cond", cond_index ).appendTo(parent);
          $("<label>").addClass("col-md-2 control-label text-right")
            .text(item["label"] ).appendTo(form_comp );
          var col = $("<div>").addClass("col-md-10 valtype").appendTo(form_comp );
          if (item["check_labels"]){
            for (var j = 0; j < item["check_labels"].length; j++ ){
              var a = item["check_labels"][j];
              var label  = $("<label>").addClass("checkbox").text(a['text']).appendTo(col );
              $("<input>").attr("type", "checkbox").addClass("form_control " + item["data_name"])
                .val(a["checked"]).attr("name", "checkbox" + item["id"])
                .attr("data-name", item["data_name"])
                .attr("data-condid", cond_index).appendTo(label );
            }
          }
          break;

        case "condition_start":
          if (cond_flag == true ){
            alert("Condition error");
            return;
          }
          cond_index++;
          cond_info.push({field: item["data_field"], value: item["data_value"], cond_index: cond_index});
          $("." + item["data_field"]).attr("data-cond", item["data_value"]);
          cond_flag = true;
          break;

        case "condition_end":
          if (cond_flag == false){
            alert("Condition error");
            return;
          }
          cond_flag = false;
          cond_index++;
          break;
      }
    }
    if (cond_flag == true ){
      alert("Condition error");
      return;
    }

    for (var i = 0;i < cond_info.length; i++ ){
      var field = cond_info[i]["field"];
      $("." + field).on("change", function(e){
        if ($(this).val() == "") return;
        var cond_index = $(this).attr("data-condind");
        cond_index = parseInt(cond_index) + parseInt(1);
        if ($(this).val() == $(this).attr("data-cond")){  
          $("[data-condind=" + cond_index + "]").show();
        }else{
          $("[data-condind=" + cond_index + "]").hide();
        }
      });

      $("." + field).on("keyup", function(e){
        if ($(this).val() == "") return;
        var cond_index = $(this).attr("data-condind");
        cond_index = parseInt(cond_index) + parseInt(1);
        if ($(this).val() == $(this).attr("data-cond")){  
          $("[data-condind=" + cond_index + "]").show();
        }else{
          $("[data-condind=" + cond_index + "]").hide();
        }
      });
    }

    $("[data-flag=true]").hide();

    $("#preview_modal").modal("show");
  });

  $("#new_table").on("click", function(){
    $(".form-component").remove();
    $("#obj_detail_wrap").html("");
    $("#source").val("");
    $("#json_zone").html("");
    $("#tb_frm_name").val("");
  });

  $("#select_list").on("click", function(ev){
    var type = $("#tb_frm_list").attr("data-type");
    var plugin_name = $("#plugin_name").val();
    $.ajax({
      url: "/plugins/" + plugin_name + "/include/classes/form_builder.php",
      data: {
        type: "load_" + type + "_data",
        value: $("#tb_frm_list").val(),
        plugin_name: plugin_name
      },
      type: "post",
      dataType: "json",
      success: function(res ){
        if (type == "table"){
          load_form_from_table(res );
        }else{
          load_form_from_json(res );
        }
        $("#tb_frm_name").val($("#tb_frm_list").val());
        $("#tb_frm_modal").modal("hide");
      }
    });
  });

  function load_form_from_table(data ){
    $(".form-component").remove();
    var parent = $("#target_fieldset");
    var columns = data["columns"];

    for (var i = 0; i < columns.length; i++ ){
      var item = columns[i];
      var data_type = item["data_type"];
      var field_name = item["column_name"];
      switch(data_type ){
        case 'enum':
          var types = item["column_type"];
          types = types.replaceAll("enum", "");
          types = types.replaceAll("(", "");
          types = types.replaceAll(")", "");
          types = types.replaceAll("'", "");
          types = types.split(",");

          var form_comp = $("<div>").attr("class", "form form-component")
                            .attr("data-id", "select_obj")
                            .attr("id", parseInt(Math.random() * 10000 + 10 ))
                            .attr("data-name", get_object_name("select_obj"))
                            .attr("draggable", false )
                            .appendTo(parent);
          $("<label>").addClass("col-md-12 control-label valtype")
                    .attr("data-valtype", "label")
                    .text(field_name ).appendTo(form_comp );
          var col = $("<div>").addClass("col-md-12").appendTo(form_comp );
          var select = $("<select>").addClass("form-control input-md valtype").attr("data-valtype", "option")
                    .appendTo(col );
          for (var j = 0; j < types.length; j++ ){
            $("<option>").attr("value", types[j]).text(types[j]).appendTo(select );
          }
          break;

        case "textarea":
          var form_comp = $("<div>").attr("class", "form form-component")
                    .attr("data-id", "textarea_obj")
                    .attr("id", parseInt(Math.random() * 10000 + 10 ))
                    .attr("data-name", get_object_name("textarea_obj"))
                    .attr("draggable", false )
                    .appendTo(parent);
          $("<label>").addClass("col-md-12 control-label valtype")
                    .attr("data-valtype", "label")
                    .text(field_name ).appendTo(form_comp );
          var col = $("<div>").addClass("col-md-12").appendTo(form_comp );
          $("<textarea>").attr("type", "text")
                    .addClass("form-control input-md valtype")
                    .attr("data-valtype", "textarea").appendTo(col );
          break;

        case "date": case "datetime":
          var form_comp = $("<div>").attr("class", "form form-component")
                    .attr("data-id", "date_obj")
                    .attr("id", parseInt(Math.random() * 10000 + 10 ))
                    .attr("data-name", get_object_name("date_obj"))
                    .attr("draggable", false )
                    .appendTo(parent);
          $("<label>").addClass("col-md-12 control-label valtype")
                    .attr("data-valtype", "label")
                    .text(field_name ).appendTo(form_comp );
          var col = $("<div>").addClass("col-md-12").appendTo(form_comp );
          $("<input>").attr("type", "text").attr("placeholder", "placeholder")
                    .addClass("form-control input-md valtype")
                    .attr("data-valtype", "placeholder").appendTo(col );
          break;

        default:
          var form_comp = $("<div>").attr("class", "form form-component")
                            .attr("data-id", "text_obj")
                            .attr("id", parseInt(Math.random() * 10000 + 10 ))
                            .attr("data-name", get_object_name("text_obj"))
                            .attr("draggable", false )
                            .appendTo(parent);
          $("<label>").addClass("col-md-12 control-label valtype")
                            .attr("data-valtype", "label")
                            .text(field_name ).appendTo(form_comp );
          var col = $("<div>").addClass("col-md-12").appendTo(form_comp );
          $("<input>").attr("type", "text").attr("placeholder", "placeholder")
                            .addClass("form-control input-md valtype")
                            .attr("data-valtype", "placeholder").appendTo(col );
          break;
      }
    }
  }

  function load_form_from_json(data ){
    $(".form-component").remove();
    var parent = $("#target_fieldset");
    for (var i = 0; i < data.length; i++ ){
      var item = data[i];
      switch(item["data_id"]){
        case "text_obj":
          var form_comp = $("<div>").attr("class", "form form-component")
                            .attr("data-id", "text_obj")
                            .attr("id", item["id"])
                            .attr("data-name", get_object_name("text_obj"))
                            .attr("draggable", false )
                            .appendTo(parent);
          $("<label>").addClass("col-md-12 control-label valtype")
                            .attr("data-valtype", "label")
                            .text(item["label"] ).appendTo(form_comp );
          var col = $("<div>").addClass("col-md-12").appendTo(form_comp );
          $("<input>").attr("type", "text").attr("placeholder", item["placeholder"])
                            .addClass("form-control input-md valtype")
                            .attr("data-valtype", "placeholder").appendTo(col );
          break;

        case "textarea_obj":
          var form_comp = $("<div>").attr("class", "form form-component")
                    .attr("data-id", "textarea_obj")
                    .attr("id", item["id"])
                    .attr("data-name", get_object_name("textarea_obj"))
                    .attr("draggable", false )
                    .appendTo(parent);
          $("<label>").addClass("col-md-12 control-label valtype")
                    .attr("data-valtype", "label")
                    .text(item["label"] ).appendTo(form_comp );
          var col = $("<div>").addClass("col-md-12").appendTo(form_comp );
          $("<textarea>").attr("type", "text")
                    .addClass("form-control input-md valtype")
                    .attr("data-valtype", "textarea").appendTo(col );
          break;

        case "ckeditor_obj":
          var form_comp = $("<div>").attr("class", "form form-component")
                    .attr("data-id", "ckeditor_obj")
                    .attr("id", item["id"])
                    .attr("data-name", get_object_name("ckeditor_obj"))
                    .attr("draggable", false )
                    .appendTo(parent);
          $("<label>").addClass("col-md-12 control-label valtype")
                    .attr("data-valtype", "label")
                    .text(item["label"] ).appendTo(form_comp );
          var col = $("<div>").addClass("col-md-12").appendTo(form_comp );
          var obj = $("<textarea>").attr("type", "text")
                    .addClass("form-control input-md valtype")
                    .attr("data-valtype", "textarea").appendTo(col );
          $(obj).trumbowyg();
          break;

        case "paragraph_obj":
          var form_comp = $("<div>").attr("class", "row mb-1r form-component")
                    .attr("data-id", "paragraph_obj")
                    .attr("id", item["id"])
                    .attr("data-name", get_object_name("paragraph_obj"))
                    .attr("draggable", false )
                    .appendTo(parent);
          var label = $("<label>").addClass("col-md-12 valtype paragraph-text")
                    .attr("data-valtype", "paragraph").appendTo(form_comp );
          $("<" + item["tag_name"] + ">").html(item["text"]).appendTo(label);
          break;

        case "file_obj":
              var form_comp = $("<div>").attr("class", "form form-component")
                        .attr("data-id", "file_obj")
                        .attr("id", item["id"])
                        .attr("data-name", get_object_name("file_obj"))
                        .attr("draggable", false )
                        .appendTo(parent);
              $("<label>").addClass("col-md-12 control-label valtype")
                        .attr("data-valtype", "label")
                        .text(item["label"] ).appendTo(form_comp );
              var col = $("<div>").addClass("col-md-12").appendTo(form_comp );
              var obj = $("<input>").attr("type", "file")
                        .attr("disable", true )
                        .addClass("form-control input-md valtype")
                        .attr("data-valtype", "file").appendTo(col );
          break;

        case "file_obj":
            var form_comp = $("<div>").attr("class", "form form-component")
                      .attr("data-id", "image_obj")
                      .attr("id", item["id"])
                      .attr("data-name", get_object_name("image_obj"))
                      .attr("draggable", false )
                      .appendTo(parent);
            $("<label>").addClass("col-md-12 control-label valtype")
                      .attr("data-valtype", "label")
                      .text(item["label"] ).appendTo(form_comp );
            var col = $("<div>").addClass("col-md-12").appendTo(form_comp );
            var obj = $("<input>").attr("type", "file")
                      .attr("disable", true )
                      .addClass("form-control input-md valtype")
                      .attr("data-valtype", "image").appendTo(col );
          break;

        case "hidden_obj":
          var form_comp = $("<div>").attr("class", "form form-component")
                            .attr("data-id", "hidden_obj")
                            .attr("id", item["id"])
                            .attr("data-name", get_object_name("hidden_obj"))
                            .attr("draggable", false )
                            .appendTo(parent);
          $("<label>").addClass("col-md-12 control-label valtype")
                            .attr("data-valtype", "label")
                            .text(item["label"] ).appendTo(form_comp );
          var col = $("<div>").addClass("col-md-12").appendTo(form_comp );
          $("<input>").attr("type", "text").attr("placeholder", item["placeholder"])
                            .addClass("form-control input-md valtype")
                            .attr("data-valtype", "placeholder").appendTo(col );
          break;

        case "date_obj":
          var form_comp = $("<div>").attr("class", "form form-component")
                    .attr("data-id", "date_obj")
                    .attr("id", item["id"])
                    .attr("data-name", get_object_name("date_obj"))
                    .attr("draggable", false )
                    .appendTo(parent);
          $("<label>").addClass("col-md-12 control-label valtype")
                    .attr("data-valtype", "label")
                    .text(item["label"] ).appendTo(form_comp );
          var col = $("<div>").addClass("col-md-12").appendTo(form_comp );
          var obj = $("<div>").addClass("input-group date valtype")
                    .attr("data-valtype", "date")
                    .attr("data-target-input", "nearest").appendTo(col );
          $("<input>").attr("type", "text").addClass("form-control datetimepicker-input").appendTo(obj );
          var div = $("<div>").addClass("input-group-append").attr("data-toggle", "datetimepicker")
                    .appendTo(obj );
          $("<div>").addClass("input-group-text").html("<i class='fa fa-calendar'></i>").appendTo(div );
          $(obj).datepicker();
          break;

        case "select_obj":
          var form_comp = $("<div>").attr("class", "form form-component")
                    .attr("data-id", "select_obj")
                    .attr("id", item["id"])
                    .attr("data-name", get_object_name("select_obj"))
                    .attr("draggable", false )
                    .appendTo(parent);
          $("<label>").addClass("col-md-12 control-label valtype")
            .attr("data-valtype", "label")
            .text(item["label"] ).appendTo(form_comp );
          var col = $("<div>").addClass("col-md-12").appendTo(form_comp );
          var select = $("<select>").addClass("form-control input-md valtype").attr("data-valtype", "option")
            .appendTo(col );
          for (var j = 0; j < item["option_values"].length; j++ ){
            var a = item["option_values"][j];
            $("<option>").attr("value", a["value"]).text(a["text"]).appendTo(select );
          }
          break;

        case "radio_obj":
          var form_comp = $("<div>").attr("class", "form form-component")
                    .attr("data-id", "radio_obj")
                    .attr("id", item["id"])
                    .attr("data-name", get_object_name("radio_obj"))
                    .attr("draggable", false )
                    .appendTo(parent);
          $("<label>").addClass("col-md-12 control-label valtype")
            .attr("data-valtype", "label")
            .text(item["label"] ).appendTo(form_comp );
          var col = $("<div>").addClass("col-md-12 valtype radio_wrap")
            .attr("data-valtype", "radios")
            .appendTo(form_comp );
          for (var j = 0; j < item["radio_labels"].length; j++ ){
            var item = item["radio_labels"][j];
            $("<label>").addClass("radio")
              .html("<inptu type='radio' value='" + item["value"] + "' name='radio" + item["id"] + "'>" + item["text"])
              .appendTo(col );
          }
          break;

        case "checkbox_obj":
          var form_comp = $("<div>").attr("class", "form form-component")
                    .attr("data-id", "checkbox_obj")
                    .attr("id", item["id"])
                    .attr("data-name", get_object_name("checkbox_obj"))
                    .attr("draggable", false )
                    .appendTo(parent);
          $("<label>").addClass("col-md-12 control-label valtype")
            .attr("data-valtype", "label")
            .text(item["label"] ).appendTo(form_comp );
          var col = $("<div>").addClass("col-md-12 valtype checkbox_wrap")
            .attr("data-valtype", "checkboxes")
            .appendTo(form_comp );
          for (var j = 0; j < item["checkbox_labels"].length; j++ ){
            var a = item["checbox_labels"][j];
            $("<label>").addClass("checkbox")
              .html("<inptu type='checkbox' value='" + a["value"] + "' name='checkbox" + a["id"] + "'>" + a["text"])
              .appendTo(col );
          }
          break;

        case "condition_start":
          var form_comp = $("<div>").attr("class", "form form-component")
                    .attr("data-id", "condition_start")
                    .attr("id", item["id"])
                    .attr("data-field", item["data_field"])
                    .attr("data-value", item["data_value"])
                    .attr("draggable", false )
                    .appendTo(parent);
          $("<div>").addClass("condition-wrap action-start").text("Condition Start").appendTo(form_comp);
          break;

        case "condition_end":
          var form_comp = $("<div>").attr("class", "form form-component")
                    .attr("data-id", "condition_end")
                    .attr("id", item["id"])
                    .attr("draggable", false )
                    .appendTo(parent);
          $("<div>").addClass("condition-wrap action-end").text("Condition end").appendTo(form_comp);
          break;
      }
    }
  }
  
  $("#load_table").on("click", function(ev){
    var plugin_name = $("#plugin_name").val();
    $.ajax({
      url: "/plugins/" + plugin_name + "/include/classes/form_builder.php",
      data: {
        type: "table_list",
        plugin_name: plugin_name
      },
      type: "post",
      dataType: "json",
      success: function(res ){
        $("#tb_frm_list").attr("data-type", "table").html("");
        for(var i = 0;i  < res.length; i++ ){
          $("<option>").attr("value", res[i]).text(res[i]).appendTo($("#tb_frm_list"));
        }
        $("#tb_frm_modal").modal("show");
      }
    });
  });

  $("#load_form").on("click", function(ev){
    var plugin_name = $("#plugin_name").val();
    $.ajax({
      url: "/plugins/" + plugin_name + "/include/classes/form_builder.php",
      data: {
        type: "form_list",
        plugin_name: plugin_name
      },
      type: "post",
      dataType: "json",
      success: function(res ){
        $("#tb_frm_list").attr("data-type", "form").html("");
        for(var i = 0;i  < res.length; i++ ){
          $("<option>").attr("value", res[i]).text(res[i]).appendTo($("#tb_frm_list"));
        }
        $("#tb_frm_modal").modal("show");
      }
    });
  });

  $("#save_form").on("click", function(ev){
    ev.preventDefault();
    genSource();
    if ($("#json_zone").text() == "[]" || $("#tb_frm_name").val().trim() == "" ){
      toastr.error("Please select the form element or table name");
      return;
    }
    var plugin_name = $("#plugin_name").val();
    $.ajax({
      url: "/plugins/" + plugin_name + "/include/classes/form_builder.php",
      data: {
        type: "save_data",
        table_name: $("#tb_frm_name").val(),
        json_data: $("#json_zone").text(),
        html_data: $("#source").val(),
        plugin_name: plugin_name
      },
      type: "post",
      dataType: "json",
      success: function(res ){
        if(res["status"] == "success" ){
          toastr.success("successfully");
        }else{}
      }
    });

  })

  $("form").delegate(".component", "mousedown", function(md){
    md.preventDefault();
    var tops = [];
    var mouseX = md.pageX;
    var mouseY = md.pageY;
    var $temp;
    var timeout;
    var $this = $(this);
    var delays = {
      main: 0,
      form: 120
    }
    var type;

    if($this.parent().parent().parent().parent().attr("id") === "components"){
      type = "main";
    } else {
      return;
    }

    var delayed = setTimeout(function(){
      if(type === "main"){
        id = $this.data("id");
        var temp_content = get_control(id );
        var tmp_obj = $.parseHTML(temp_content["element"]);
        var obj_name = get_object_name(id );
        var div = $("<div>").addClass("form-group form-component").attr("data-id", id)
                            .attr("id", Math.ceil(Math.random() * 1000000))
                            .attr("data-name", obj_name )
                            .html(tmp_obj );
        var obj = $this.clone();
        $(obj).removeClass("component").addClass("form-component");
        $temp = $("<form class='form-horizontal col-md-6' id='temp'></form>").append(div );//temp_content["element"]);//
      } else {
        if($this.attr("id") !== "legend"){
          $temp = $("<form class='form-horizontal col-md-6' id='temp'></form>").append($this);
        }
      }

      $("body").append($temp);
      $temp.css({"position" : "absolute",
                 "top"      : mouseY - ($temp.height()/2) + "px",
                 "left"     : mouseX - ($temp.width()/2) + "px",
                 "opacity"  : "0.9"}).show()

      var half_box_height = ($temp.height()/2);
      var half_box_width = ($temp.width()/2);
      var $target = $("#target");
      var tar_pos = $target.position();
      var $target_component = $("#target .form-component");

      $(document).delegate("body", "mousemove", function(mm){
        var mm_mouseX = mm.pageX;
        var mm_mouseY = mm.pageY;

        $temp.css({ "top"   : mm_mouseY - half_box_height + "px",
                    "left"  : mm_mouseX - half_box_width  + "px"});

        if ( mm_mouseX > tar_pos.left &&
          mm_mouseX < tar_pos.left + $target.width() + $temp.width()/2 &&
          mm_mouseY > tar_pos.top &&
          mm_mouseY < tar_pos.top + $target.height() + $temp.height()/2 + 157
          ){
            $("#target").css("background-color", "#fafdff");
            $target_component.css({"border-top" : "1px solid white", "border-bottom" : "none"});
            tops = $.grep($target_component, function(e){
              return ($(e).position().top -  mm_mouseY + 157 + half_box_height > 0 && $(e).attr("id") !== "legend");
            });
            if (tops.length > 0){
              $(tops[0]).css("border-top", "5px solid #22aaff");
            } else{
              if($target_component.length > 0){
                $($target_component[$target_component.length - 1]).css("border-bottom", "5px solid #22aaff");
              }
            }
          } else{
            $("#target").css("background-color", "#fff");
            $target_component.css({"border-top" : "1px solid white", "border-bottom" : "none"});
            $target.css("background-color", "#fff");
          }
      });

      $("body").delegate("#temp", "mouseup", function(mu){
        mu.preventDefault();

        var mu_mouseX = mu.pageX;
        var mu_mouseY = mu.pageY;
        var tar_pos = $target.position();

        $("#target .form-component").css({"border-top" : "1px solid white", "border-bottom" : "none"});

        // acting only if mouse is in right place
        if (mu_mouseX + half_box_width > tar_pos.left &&
          mu_mouseX - half_box_width < tar_pos.left + $target.width() &&
          mu_mouseY + half_box_height > tar_pos.top &&
          mu_mouseY - half_box_height < tar_pos.top + $target.height() + 57
          ){
            $temp.attr("style", null);
            // where to add
            if(tops.length > 0){
              $($temp.html()).insertBefore(tops[0]);
            } else {
              $("#target fieldset").append($temp.append("\n\n\ \ \ \ ").html());
            }
          } else {
            // no add
            $("#target .form-component").css({"border-top" : "1px solid white", "border-bottom" : "none"});
            tops = [];
          }

        //clean up & add popover
        $target.css("background-color", "#fff");
        $(document).undelegate("body", "mousemove");
        $("body").undelegate("#temp","mouseup");
        $temp.remove();
        genSource();
      });
    }, delays[type]);

    $(document).mouseup(function () {
      clearInterval(delayed);
      return false;
    });
    $(this).mouseout(function () {
      clearInterval(delayed);
      return false;
    });
  });

  $("body").delegate(".add_check_item", "click", function(ev){
    ev.preventDefault();
    add_check_block($("#checkbox_obj_wrap"), "Option", "checkbox_" + parseInt(2 + Math.random() * 100));
  });

  $("body").delegate(".add_radio_item", "click", function(ev){
    ev.preventDefault();
    add_radio_block($("#radio_obj_wrap"), "Option", "radio_" + parseInt(2 + Math.random() * 100));
  });

  $("body").delegate(".save_data", "click", function(ev){
    ev.preventDefault();
    var datatype = $(prev_obj).attr("data-id");
    if (datatype == "" ) return;

    switch(datatype ){
      case "text_obj":
        $(prev_obj).find('label').text($("#label").val());
        $(prev_obj).attr("data-name", $("#name").val());
        $(prev_obj).find("input").attr("placeholder", $("#placeholder").val());
        break;
      case "textarea_obj":
        $(prev_obj).find('label').text($("#label").val());
        $(prev_obj).attr("data-name", $("#name").val());
        break;
      case "ckeditor_obj":
        $(prev_obj).find('label').text($("#label").val());
        $(prev_obj).attr("data-name", $("#name").val());
        break;
      case "file_obj":
        $(prev_obj).find('label').text($("#label").val());
        $(prev_obj).attr("data-name", $("#name").val());
        break;
      case "paragraph_obj":
        $(prev_obj).find('label').html("<" + $("#paragraph-select").val() + ">" + $("#text").val() + "</" + $("#paragraph-select").val() + ">");
        $(prev_obj).attr("data-tagname", $("#paragraph-select").val());
      case "image_obj":
        $(prev_obj).find('label').text($("#label").val());
        $(prev_obj).attr("data-name", $("#name").val());
        break;
      case "hidden_obj":
        $(prev_obj).find('label').text($("#label").val());
        $(prev_obj).attr("data-name", $("#name").val());
        break;
      case "date_obj":
        $(prev_obj).find('label').text($("#label").val());
        $(prev_obj).find("data-name", $("#name").val());
        break;
      case "select_obj":
        $(prev_obj).find('label').text($("#label").val());
        $(prev_obj).attr("data-name", $("#name").val());
        var select_obj = $(prev_obj).find("select");
        $(select_obj).html("");

        var items = $(".select_item");
        for (var i = 0; i < items.length; i++ ){
          var item = items[i];
          $("<option>").attr("value", $(item).find(".obj-value").val())
              .text($(item).find(".obj-label").val())
              .appendTo($(select_obj));
        }
        break;
      case "checkbox_obj":
        $(prev_obj).find('.control-label').text($("#label").val());
        $(prev_obj).attr("data-name", $("#name").val());

        var select_obj = $(prev_obj).find(".checkbox_wrap");
        $(select_obj).html("");
        var items = $(".check_item");
        for (var i = 0; i < items.length; i++ ){
          var item = items[i];
          var val = $(item).find(".obj-value").val();
          var label = $(item).find(".obj-label").val();

          $("<label>").attr("class", "checkbox").html("<input type='checkbox' value='" + val + "'>" + label + "</label>")
              .appendTo(select_obj );
        }
        break;
      case "radio_obj":
        $(prev_obj).find('.control-label').text($("#label").val());
        $(prev_obj).attr("data-name", $("#name").val());

        var select_obj = $(prev_obj).find(".radio_wrap");
        $(select_obj).html("");
        var items = $(".radio_item");
        for (var i = 0; i < items.length; i++ ){
          var item = items[i];
          var val = $(item).find(".obj-value").val();
          var label = $(item).find(".obj-label").val();

          $("<label>").attr("class", "radio").html("<input type='radio' value='" + val + "'>" + label + "</label>")
              .appendTo(select_obj );
        }
        break;
      case "condition_start":
        $(prev_obj).attr("data-field", $("#cond_start_select").val())
              .attr("data-value", $("#cond_start_value").val());
        break;
    }

    toastr.success("successfully");
  });

  $("body").delegate(".del_data", "click", function(ev){
    ev.preventDefault();
    $(prev_obj).remove();
    $(this).parent().parent().remove();
    prev_obj = null;
  });

  var genSource = function(){
    var $temptxt = $("<div>").html($("#target").html());
    $temptxt.find(".form-component[data-id=condition_start]").remove();
    $temptxt.find(".form-component[data-id=condition_end]").remove();
    $($temptxt).find(".form-component")
      .attr({"title": null,
        "data-original-title":null,
        "data-type": null,
        "data-content": null,
        "rel": null,
        "trigger":null,
        "data-html":null,
        "style": null});
    $($temptxt).find(".valtype").attr("data-valtype", null).removeClass("valtype");
    $($temptxt).find(".form-component").removeClass("form-component");
    $($temptxt).find("form").attr({"id":  null, "style": null}); 
    $("#source").val($temptxt.html().replace(/\n\ \ \ \ \ \ \ \ \ \ \ \ /g,"\n"));
    
    var json_obj = get_json_data();
    $("#json_zone").text(JSON.stringify(json_obj));
  }

  function get_json_data(){
    // generate json data
    var json_obj = [];
    var components = $(".form-component");
    for (var i = 0; i < components.length; i++ ){
      var tmp_obj = {};
      var comp = components[i];
      var data_id = $(comp).attr("data-id");
      var id = $(comp).attr("id");
      var name = $(comp).attr("data-name");
      tmp_obj["data_id"] = data_id;
      tmp_obj["id"] = id;
      tmp_obj["data_name"] = name;

      switch(data_id ){
        case "text_obj":
          label = $(comp).find(".control-label").text();
          placeholder = $(comp).find(".form-control").attr("placeholder");
          tmp_obj["label"] = label;
          tmp_obj["placeholder"] = placeholder;
          break;
        case "textarea_obj":
          label = $(comp).find(".control-label").text();
          placeholder = $(comp).find(".form-control").attr("placeholder");
          tmp_obj["label"] = label;
          tmp_obj["placeholder"] = placeholder;
          break;
        case "ckeditor_obj":
          label = $(comp).find(".control-label").text();
          placeholder = $(comp).find(".form-control").attr("placeholder");
          tmp_obj["label"] = label;
          tmp_obj["placeholder"] = placeholder;
          break;
        case "file_obj":
          label = $(comp).find(".control-label").text();
          tmp_obj["label"] = label;
          break;
        case "image_obj":
          label = $(comp).find(".control-label").text();
          tmp_obj["label"] = label;
          break;
        case "hidden_obj":
          label = $(comp).find(".control-label").text();
          tmp_obj["label"] = label;
          break;
        case "paragraph_obj":
          tmp_obj["tag_name"] = $(comp).attr("data-tagname");
          tmp_obj["text"] = $(comp).find("label").text();
          break;
        case "date_obj":
          label = $(comp).find(".control-label").text();
          tmp_obj["label"] = label;
          break;
        case "checkbox_obj":
          label = $(comp).find(".control-label").text();
          var checks = $(comp).find(".checkbox");
          var check_labels = [];
          for (var j = 0; j < checks.length; j++ ){
            check_labels.push({"text": $(checks[j]).text(), "checked": $(checks[j]).is(":checked")});
          }
          tmp_obj["label"] = label;
          tmp_obj["check_labels"] = check_labels;
          break;
        case "select_obj":
          label = $(comp).find(".control-label").text();
          var options = $(comp).find("select.form-control option");
          var option_values = [];
          for (var j = 0; j < options.length; j++ ){
            option_values.push({"value": $(options[j]).attr("value"), "text": $(options[j]).text()});
          }
          label = $(comp).find(".control-label").text();
          tmp_obj["label"] = label;
          tmp_obj["option_values"] = option_values;
          tmp_obj["selected"] = $(comp).find("select.form-control").val();
          break;
        case "radio_obj":
          label = $(comp).find(".control-label").text();
          var radios = $(comp).find(".radio");
          var radio_labels = [];
          for (var j = 0; j < radios.length; j++ ){
            radio_labels.push({"value": $(radios[j]).find("input").val(), "text": $(radios[j]).text()});
          }
          tmp_obj["label"] = label;
          tmp_obj["radio_labels"] = radio_labels;
          break;
        case "condition_start":
          var data_field = $(comp).attr("data-field");
          var data_value = $(comp).attr("data-value");
          tmp_obj["data_field"] = data_field;
          tmp_obj["data_value"] = data_value;
          break;
        case "condition_end":
          break;
      }
      json_obj.push(tmp_obj );
    }
    return json_obj;
  }

  $("#target").delegate(".form-component", "click", function(e){
    e.preventDefault();
    var $active_component = $(this);
    prev_obj = $active_component;
    var obj_type = $(this).data("id");
    var control = get_control(obj_type );
    //var name = set_object_name($active_component, obj_type );
    switch(obj_type ){
      case "condition_start":
        $("#obj_detail_wrap").html(control["property"]);
        set_condition_start($active_component );
        break;
      case "condistion_end":
        $("#obj_detail_wrap").html("Condition End");
        break;
      default:
        $("#obj_detail_wrap").html(control["property"]);
        set_obj_value($active_component );

        break;
    }
    $("#name").val($active_component.attr("data-name"));
  });

  function get_object_name(obj_type ){
    var index = $("div.form-component[data-id=" + obj_type + "]").length;
    index++;
    var label = "";
    switch(obj_type ){
      case "text_obj":
        label = "text_";
        break;
      case "textarea_obj":
        label = "textarea_";
        break;
      case "ckeditor_obj":
        label = "editor_";
        break;
      case "file_obj":
        label = "file_";
        break;
      case "paragraph_obj":
        label = "paragraph_";
        break;
      case "image_obj":
        label = "image_";
        break;
      case "hidden_obj":
        label = "hidden_";
        break;
      case "date_obj":
        label = "date_";
        break;
      case "select_obj":
        label = "select_";
        break;
      case "checkbox_obj":
        label = "checkbox_";
        break;
      case "radio_obj":
        label = "radio_";
        break;
    }
    //$(obj ).attr("data-name", label + index );
    return label + index;
  }

  function set_condition_start(obj){
    var id = $(obj ).attr("id");
    var components = $(".form-component");
    var condition_select = $("#cond_start_select");
    $(condition_select).html("");
    for (var i = 0; i < components.length; i++ ){
      var item = components[i];
      var name = $(item).attr("data-name");
      if ($(item).attr("id") == id ) break;
      if ($(item).attr("data-id") != "condition_end" && $(item).attr("data-id") != "condition_start" ){
        $("<option>").attr("value", name ).text(name ).appendTo(condition_select );
      }
    }
    $(condition_select).val($(obj).attr("data-field"));
    $("#cond_start_value").val($(obj).attr("data-value"));
  }

  function set_obj_value(obj ){
    var valtypes = $(obj).find(".valtype");
    for(var i = 0; i < valtypes.length; i++ ){
      var item = valtypes[i];
      var valtype = $(item).attr("data-valtype");
      switch(valtype ){
        case "label":
          $("#label").val($(item).text());
          break;
        case "paragraph":
          $("#text").val($(item).text());
          break;
        case "placeholder":
          $("#placeholder").val($(item).attr("placeholder"));
          break;
        case "option":
          var items = $(item ).find("option");
          var parent = $("#select_obj_wrap");

          for (var j = 0; j < items.length; j++ ){
            var item = items[j];
            add_select_block(parent, $(item).text(), $(item).val());
          }
          break;
        case "checkboxes":
          var items = $(item ).find(".checkbox");
          var values = [];
          var parent = $("#checkbox_obj_wrap");

          for (var j = 0; j < items.length; j++ ){
            var item = items[j];
            // values.push({
            //   "label": $(item ).text(),
            //   "value": $(item ).find("input").is(":checked")
            // });
            add_check_block(parent, $(item).text(), $(item).find("input").val());
          }
          break;
        case "radios":
          var items = $(item ).find(".radio");
          var values = [];
          var parent = $("#radio_obj_wrap");

          for (var j = 0; j < items.length; j++ ){
            var item = items[j];
            values.push({
              "label": $(item ).text(),
              "value": $(item ).find("input").is(":checked")
            });
            add_radio_block(parent, $(item).text(), $(item).find("input").val());
          }
          break;
      }
    }
  }

  function add_check_block(parent, text, value ){
    var row = $("<div class='row'>").appendTo(parent );
    var sub_item = $("<div class='col-md-12'>").appendTo(row );
    $("<label class='check_label'>").text("checkbox").appendTo(sub_item );
    row = $("<div class='row check_item'>").appendTo(sub_item );
    var col1 = $("<div>").addClass("col-md-5").appendTo(row );
    var col2 = $("<div>").addClass("col-md-6").appendTo(row );
    var col3 = $("<div>").addClass("col-md-1 flex-display").appendTo(row );
    $("<label class='control-label item_label full-width'>").text("Label").appendTo(col1 );
    $("<input class='form-control obj-label'>").val(text ).appendTo(col1 );
    $("<label class='control-label item_label full-width'>").text("value").appendTo(col2 );
    $("<input class='form-control obj-value'>").val(value ).appendTo(col2 );
    $("<button>").addClass("btn btn-xs btn-danger").html("<i class='fa fa-trash'></i>")
        .on("click", function(){
          $(this).parent().parent().parent().parent().remove();
        })
        .appendTo(col3 );
  }

  function add_radio_block(parent, text, value ){
    var row = $("<div class='row'>").appendTo(parent );
    var sub_item = $("<div class='col-md-12'>").appendTo(row );
    $("<label class='radio_label'>").text("radiobox").appendTo(sub_item );
    row = $("<div class='row radio_item'>").appendTo(sub_item );
    var col1 = $("<div>").addClass("col-md-5").appendTo(row );
    var col2 = $("<div>").addClass("col-md-6").appendTo(row );
    var col3 = $("<div>").addClass("col-md-1 flex-display").appendTo(row );
    $("<label class='control-label item_label full-width'>").text("Label").appendTo(col1 );
    $("<input class='form-control obj-label'>").val(text ).appendTo(col1 );
    $("<label class='control-label item_label full-width'>").text("value").appendTo(col2 );
    $("<input class='form-control obj-value'>").val(value ).appendTo(col2 );
    $("<button>").addClass("btn btn-xs btn-danger").html("<i class='fa fa-trash'></i>")
        .on("click", function(){
          $(this).parent().parent().parent().parent().remove();
        })
        .appendTo(col3 );
  }

  function add_select_block(parent, text, value ){
    var row = $("<div class='row'>").appendTo(parent );
    var sub_item = $("<div class='col-md-12'>").appendTo(row );
    $("<label class='select_label'>").text("selectbox").appendTo(sub_item );
    row = $("<div class='row select_item'>").appendTo(sub_item );
    var col1 = $("<div>").addClass("col-md-5").appendTo(row );
    var col2 = $("<div>").addClass("col-md-6").appendTo(row );
    var col3 = $("<div>").addClass("col-md-1 flex-display").appendTo(row );
    $("<label class='control-label item_label full-width'>").text("Label").appendTo(col1 );
    $("<input class='form-control obj-label'>").val(text ).appendTo(col1 );
    $("<label class='control-label item_label full-width'>").text("value").appendTo(col2 );
    $("<input class='form-control obj-value'>").val(value ).appendTo(col2 );
    $("<button>").addClass("btn btn-xs btn-danger").html("<i class='fa fa-trash'></i>")
        .on("click", function(){
          $(this).parent().parent().parent().parent().remove();
        })
        .appendTo(col3 );
  }

  $("#navtab").delegate("li a", "click", function(e){
    genSource();
  });
});

function get_control(id ){
  for(var i = 0;i < controls.length; i++ ){
    if (controls[i]["id"] == id ){
      return controls[i];
    }
  }
}


function accor_action(){
  if ($(this).parent().attr("data-visible") == "true" ){
      $(this).parent().attr("data-visible", "false");
      $(this).parent().css("max-width", "40px");
      $(this).parent().find(".flex-comp").hide();
  }else{
      $(this).parent().attr("data-visible", "true");
      $(this).parent().find(".flex-comp").show();
  }
  
  var comp_wrap = $(".comp-wrap");
  var prop_wrap = $(".prop-wrap");
  var comp_flag = $(comp_wrap).attr("data-visible");
  var prop_flag = $(prop_wrap).attr("data-visible");

  var length = 0;
  if (comp_flag == "true" ){
    length += parseInt(267); 
    $(comp_wrap).css("max-width", "267px");
  }else{
    length += parseInt(40);
  }

  if (prop_flag == "true"){
    $(prop_wrap).css("max-width", "401px");
    length += parseInt(401);
  }else{
    length += parseInt(40);
  }

  $(".ele-wrap").css("width", "calc(100% - " + length + "px)");
}
