$(document).ready(function(){
  frmadv_add_wizard();
  $(".frmadv_wizard_ul li").addClass("active");
  frmadv_select_wizard_content();
  frmadv_init_formlist();
  $("#frmadv_add_form").on("click", frmadv_add_form_in_content);
  $("#frmadv_preview_all").on("click", frmadv_preview_advanced_form);
  $("#frmadv-preview-body").on("click", ".frmadv_preview_acc_header", frmadv_preview_accordion);
  $("#frmadv_preview_wizard_prev").on("click", frmadv_preview_prev_wizard);
  $("#frmadv_preview_wizard_next").on("click", frmadv_preview_next_wizard);
  $("#frmadv_preview_wizard_finish").on("click", frmadv_preview_finish_wizard);
});

function frmadv_preview_prev_wizard(){
  var wizard_items = $(".frmadv_preview_wizard_item");
  var active_wizard = $(".frmadv_preview_wizard_item.active");
  var active_index = $(active_wizard).attr("data-index");
  
  active_index = parseInt(active_index) - 1;
  active_index = active_index == 0 ? 1 : active_index;
  $(".frmadv_preview_wizard_item").removeClass("active");
  $(".frmadv_preview_wizard_item:nth-child(" + active_index + ")").addClass("active");

  if (active_index <= 1 ){
    $("#frmadv_preview_wizard_prev").addClass("hide");
  }else{
    $("#frmadv_preview_wizard_prev").removeClass("hide");
  }

  $("#frmadv_preview_wizard_finish").addClass("hide");
  $("#frmadv_preview_wizard_next").removeClass("hide");
  if (wizard_items.length <= 1 ){
    $("#frmadv_preview_wizard_prev").addClass("hide");
    $("#frmadv_preview_wizard_next").addClass("hide");
    $("#frmadv_preview_wizard_finish").removeClass("hide");
  }
}

function frmadv_preview_next_wizard(){
  var wizard_items = $(".frmadv_preview_wizard_item");
  var active_wizard = $(".frmadv_preview_wizard_item.active");
  var active_index = $(active_wizard).attr("data-index");
  
  active_index = parseInt(active_index) + 1;
  active_index = active_index >= wizard_items.length ? wizard_items.length : active_index;
  $(".frmadv_preview_wizard_item").removeClass("active");
  $(".frmadv_preview_wizard_item:nth-child(" + active_index + ")").addClass("active");

  if (active_index >= wizard_items.length ){
    $("#frmadv_preview_wizard_next").addClass("hide");
    $("#frmadv_preview_wizard_finish").removeClass("hide");
  }else{
    $("#frmadv_preview_wizard_next").removeClass("hide");
    $("#frmadv_preview_wizard_finish").addClass("hide");
  }

  $("#frmadv_preview_wizard_prev").removeClass("hide");
  if (wizard_items.length <= 1 ){
    $("#frmadv_preview_wizard_prev").addClass("hide");
    $("#frmadv_preview_wizard_next").addClass("hide");
    $("#frmadv_preview_wizard_finish").removeClass("hide");
  }
}

function frmadv_preview_finish_wizard(){
  toastr.success("Done");
}

function frmadv_preview_accordion(){
  var hasActive = $(this).parent().find(".frmadv_preview_acc_body").hasClass("active");
  $(this).parent().parent().find(".frmadv_preview_acc_body").removeClass("hide");
  if (hasActive){
    $(this).parent().find(".frmadv_preview_acc_body").removeClass("active");
  }else{
    $(this).parent().find(".frmadv_preview_acc_body").addClass("active");
  }
}

function frmadv_preview_advanced_form(){
  var adv_json_form = get_frmadv_advanced_form();
  var parent = $("#frmadv-preview-body");
  $(parent).html("");

  if (adv_json_form.length < 2){
    $("#frmadv_preview_wizard_action").addClass("hide");
  }else{
    $("#frmadv_preview_wizard_action").removeClass("hide");
  }

  for (var i = 0; i < adv_json_form.length; i++ ){
    var wizard_item = adv_json_form[i];
    var wizard_name = wizard_item["name"];
    var wizard_id = wizard_item["id"];
    var tab_json = wizard_item["tabs"];
    var active_cls = i == 0 ? " active" : "";
    var wizard_div = $("<div>").attr("data-id", wizard_id)
          .addClass("frmadv_preview_wizard_item" + active_cls)
          .attr("data-index", (i+1))
          .appendTo(parent );
    var tab_div_wrap = $("<div>").addClass("frmadv_preview_tab_wrap").appendTo(wizard_div);
    var tab_ul = $("<ul>").addClass("nav nav-tabs").attr("role", "tablist").appendTo(tab_div_wrap);
    var tab_content = $("<div>").addClass("tab-content px-1r").appendTo(tab_div_wrap);

    if (tab_json.length < 2){
      $(tab_ul).addClass("hide");
    }

    for (var j = 0; j < tab_json.length; j++ ){
      var tab_item = tab_json[j];
      var tab_name = tab_item["name"];
      var tab_id = tab_item["id"];
      var acc_json = tab_item["accordions"];
      active_cls = j == 0 ? " active" : "";

      var tab_li = $("<li>").addClass("nav-item" + active_cls).appendTo(tab_ul);
      $("<a>").attr("data-toggle", "pill")
            .attr("href", "#tab_content_" + tab_id )
            .attr("role", "tab")
            .attr("aria-controls", "tab_content_" + tab_id)
            .attr("aria-selected", "true")
            .html(tab_name)
            .appendTo(tab_li);
      
      var tab_pane = $("<div>").addClass("tab-pane fade show" + active_cls)
            .attr("id", "tab_content_" + tab_id)
            .attr("role", "tabpanel")
            .attr("aria-labelledby", "tab_content_tab")
            .appendTo(tab_content);
      var tab_body = $("<div>").addClass("card-body p-0").appendTo(tab_pane);
      var row = $("<div>").addClass("row").appendTo(tab_body);
      var acc_wrap = $("<div>").addClass("col").appendTo(row);


      for (var k = 0; k < acc_json.length; k++){
        var acc_item = acc_json[k];
        var acc_name = acc_item["name"];
        var acc_id = acc_item["id"];
        var forms = acc_item["forms"];
        active_cls = k == 0 ? " active" : "";

        var acc_item = $("<div>").addClass("frmadv_preview_acc_item").appendTo(acc_wrap);
        var acc_title = $("<h3>").addClass("frmadv_preview_acc_header").html(acc_name).appendTo(acc_item);
        var acc_body = $("<div>").addClass("frmadv_preview_acc_body" + active_cls).appendTo(acc_item);
        if (acc_json.length < 2){
          $(acc_title).addClass("hide");
        }
        for (var l = 0; l < forms.length; l++){
          var form_item = forms[l];
          frmadv_add_form(acc_body, form_item);
        }
      }
    }
  }
  $("#frmadv-preview-modal").modal("show");
}

function frmadv_add_form(parent, form_item ){
  var plugin_name = $("#plugin_name").val();
  $.ajax({
      url: "/plugins/" + plugin_name + "/include/classes/plugin_formbuilder_adv.php",
      data:{
          type: "form_data",
          plugin_name: plugin_name,
          form_name: form_item
      },
      type: "post",
      dataType: "json",
      success: function(data){
        frmadv_builder_form(parent, data);
      }
  });
}

function frmadv_builder_form(parent, json_obj){
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
}

function get_frmadv_advanced_form(){
  var json = [];
  var wizard_list = $(".frmadv_wizard_ul li");
  var wizard_json = [];

  for (var i = 0; i < wizard_list.length; i++){
    var item = wizard_list[i];
    var wizard_name = $(item).find(".frmadv_wizard_name").val();
    var wizard_id = $(item).attr("data-id");

    var wizard_tabs = $("#wizard_" + wizard_id).find(".nav-item");
    var tab_json = [];
    for (var j = 0; j < wizard_tabs.length; j++){
      var tab_item = wizard_tabs[j];
      var tab_id = $(tab_item).attr("data-id");
      var tab_name = $(tab_item).find("a.nav-link").html();

      var accors = $("#frmadv_content_" + tab_id).find(".accordion");
      var acc_json = [];
      for (var k = 0; k < accors.length; k++){
        var acc_item = $(accors[k]).find(".accordion-item");
        var acc_name = $(acc_item).find(".accordion-header .accordion-button").html();
        var acc_id = $(acc_item).attr("data-id");

        var forms = $(acc_item).find(".frmadv_formbuilder_wrap");
        var form_json = [];
        for (var l = 0; l < forms.length; l++){
          var form_item = forms[l];
          var form_name = $(form_item).attr("data-form");
          form_json.push(form_name);
        }
        if (form_json.length > 0 ){
          acc_json.push({
            name: acc_name,
            id: acc_id,
            forms: form_json
          });
        }
      }

      if (acc_json.length > 0 ){
        tab_json.push({
          name: tab_name,
          id: tab_id,
          accordions: acc_json
        });
      }
    }

    if (tab_json.length > 0){
      wizard_json.push({
        name: wizard_name,
        id: wizard_id,
        tabs: tab_json
      });
    }
  }
  
  return wizard_json;
}

function frmadv_add_form_in_content(){
  var active_body = frmadv_get_active_wrap();
  if (!active_body){
    return;
  }

  var form_name = $("#frmadv_formlist_select").val();
  var form_div = $("<div>").addClass("frmadv_formbuilder_wrap")
        .attr("data-form", form_name).appendTo(active_body);
  
  $("<h3>").text(form_name).appendTo(form_div);
  $("<button>").attr("type", "button").addClass("btn btn-primary")
      .html("Preview").attr("data-form", form_name)
      .on("click", frmadv_preview_form)
      .appendTo(form_div);
  $("<button>").attr("type", "button").addClass("btn btn-danger")
      .html("Delete").on("click", frmadv_delete_form)
      .appendTo(form_div);
}

function frmadv_preview_form(){
  var form_name = $(this).attr("data-form");
  var parent = $("#frmadv-preview-body");
  $(parent).html("");
  frmadv_add_form(parent, form_name);
  $("#frmadv-preview-modal").modal("show");
}

function frmadv_delete_form(){
  if (!confirm("Are you really going to remove this form?")) return true;
  $(this).parent().remove();
}

function frmadv_init_formlist(){
  var plugin_name = $("#plugin_name").val();
  $.ajax({
      url: "/plugins/" + plugin_name + "/include/classes/plugin_formbuilder_adv.php",
      data:{
          type: "formbuilder_list",
          plugin_name: plugin_name
      },
      type: "post",
      dataType: "json",
      success: function(data){
        var parent = $("#frmadv_formlist_select");
        for (var i = 0;i < data.length; i++){
          $("<option>").attr("value", data[i]).text(data[i]).appendTo(parent);
        }
      }
  });
}

function frmadv_get_active_wrap(){
  var action_wizard = $(".frmadv_wizard_ul li.active");
  var active_wizard_id = $(action_wizard).attr("data-id");

  var active_tab = $("#wizard_" + active_wizard_id).find(".nav-item a.active");
  var active_tab_id = $(active_tab).parent().attr("data-id");

  var accor_content = $("#frmadv_content_" + active_tab_id).find(".frmadv_accordion-collapse.active");
  if (accor_content.length > 0 ){
    return $(accor_content).find(".accordion-body");
  }else{
    toastr.error("Please select the accordion content");
    return false;
  }
}

function frmadv_select_wizard_content(){
  var action_wizard = $(".frmadv_wizard_ul li.active");
  var active_wizard_id = $(action_wizard).attr("data-wizardid");
  $(".frmadv_wizard_item").addClass("hide");
  $("#" + active_wizard_id).removeClass("hide");
}

function frmadv_add_wizard(){
  var wizard_id = generate_id();
  var parent = $(".frmadv_wizard_ul");
  var li = $("<li>")
    .attr("data-id", wizard_id)
    .attr("data-wizardid", "wizard_" + wizard_id)
    .on("click", select_wizard )
    .appendTo(parent);
  $("<input>").attr("contenteditable", "true").addClass("form-control frmadv_wizard_name")
    .attr("value", "Wizard " + ($(parent).find("li").length + 1)).appendTo(li);
  $("<button>").attr("type", "button").addClass("frmadv_add_wizard btn btn-default")
      .on("click", frmadv_add_wizard).text("+").appendTo(li);
  $("<button>").attr("type", "button").addClass("frmadv_remove_wizard btn btn-danger")
      .on("click", frmadv_remove_wizard).text("x").appendTo(li);

  frmadv_add_wizard_content(wizard_id);
}

function frmadv_add_wizard_content(wizard_id){
  var parent = $(".frmadv_wizard_wrap");
  var item = $("<div>").addClass("frmadv_wizard_item")
      .attr("data-id", wizard_id)
      .attr("data-wizardid", "wizard_" + wizard_id)
      .attr("id", "wizard_" + wizard_id)
      .appendTo(parent);
  $("<ul>").addClass("nav nav-tabs frmadv_tab_ul").attr("role", "tablist")
      .appendTo(item);
  
  $("<div>").addClass("tab-content border_gray px-1r frmadv_tab_content_wrap")
      .appendTo(item);

  frmadv_add_tab_content(wizard_id);
  $("#wizard_" + wizard_id).find(".nav-item a").click();
}

function frmadv_add_tab_content(wizard_id ){
  var content_id = generate_id();
  var wizard_wrap = $("#wizard_" + wizard_id);
  var tabs = $(wizard_wrap).find("ul.frmadv_tab_ul");
  var tab_content = $(wizard_wrap).find(".frmadv_tab_content_wrap");
  var li = $("<li>").addClass("nav-item")
    .attr("data-id", content_id)
    .attr("data-lid", "li_" + content_id)
    .appendTo(tabs);
  $("<a>").addClass("nav-link no-border padding-1x").attr("data-toggle", "pill")
    .attr("contenteditable", "true")
    .text("Tab " + $(tabs).find("li").length)
    .attr("href", "#frmadv_content_" + content_id)
    .appendTo(li);
  $("<span>").text("+").addClass("frm_tab_add")
    .attr("data-wizardid", wizard_id)
    .on("click", frmadv_add_tab)
    .appendTo(li);
  $("<span>").text("x").addClass("frmadv_tab_close")
    .on("click", frmadv_close_tab)
    .attr("data-wizardid", wizard_id)
    .appendTo(li);
  var tab_pan = $("<div>").addClass("tab-pane fade")
    .attr("id", "frmadv_content_" + content_id)
    .attr("role", "tabpanel")
    .attr("data-id", content_id)
    .appendTo(tab_content);
  var card_body = $("<div>").addClass("card-body p-0").appendTo(tab_pan);
  var row = $("<div>").addClass("row").appendTo(card_body);
  var col = $("<div>").addClass("col-md-12 frmadv_content_items_wrap").appendTo(row);

  frmadv_add_accordion_content(content_id );
}

function frmadv_add_accordion_content(content_id){
  var acc_id = generate_id();
  var parent = $("#frmadv_content_" + content_id);
  parent = $(parent).find(".frmadv_content_items_wrap");
  var accor_wrap = $("<div>").addClass("accordion").appendTo(parent);
  var acc_item = $("<div>")
        .attr("data-id", acc_id)
        .attr("id", "acc_" + acc_id)
        .addClass("accordion-item").appendTo(accor_wrap);
  var acc_header = $("<h4>")
        .attr("id", "accor_header_" + acc_id )
        .addClass("accordion-header").appendTo(acc_item);
  $("<button>").addClass("accordion-button").attr("type", "button")
        .attr("data-bs-toggle", "collapse")
        .attr("data-bs-target", "#accor_content_" + acc_id)
        .attr("aria-expaned", "true").attr("aria-controls", "collapse")
        .attr("aria-controls", "#accor_content_" + acc_id)
        .html("Accordion " + $(parent).find(".accordion-item").length)
        .on("click", frmadv_collapse_accordion)
        .appendTo(acc_header);
  $("<button>").addClass("btn btn-default frmadv_add_acc_content btn-md")
        .attr("data-contentid", content_id)
        .html("+").attr("type", "button")
        .on("click", function(e){frmadv_add_accordion_content($(this).attr("data-contentid"));})
        .appendTo(acc_header);
  $("<button>").addClass("btn btn-danger frmadv_add_acc_content btn-md")
        .attr("data-contentid", content_id)
        .html("x").attr("type", "button")
        .on("click", function(e){frmadv_remove_accordion_content(this, $(this).attr("data-contentid"));})
        .appendTo(acc_header);
  var acc_content = $("<div>").attr("id", "accor_content_" + acc_id)
        .addClass("frmadv_accordion-collapse frmadv_collapse hide")
        .attr("aria-labelledby", "accor_header_" + acc_id)
        .attr("data-bs-parent", "#accor_header_" + acc_id)
        .appendTo(acc_item);
  $("<div>").addClass("accordion-body").appendTo(acc_content);
}

function frmadv_collapse_accordion(e){
  e.preventDefault();
  var id = $(this).attr("data-bs-target");
  var hasHide = $(id).hasClass("hide");
  $(this).parent().parent().parent().parent().find(".frmadv_accordion-collapse").addClass("hide").removeClass("active");
  if (hasHide){
    $(id).removeClass("hide").addClass("active");
  }else{
    $(id).addClass("hide").removeClass("active");
  }  
}

function frmadv_remove_accordion_content(obj, content_id){
  if ($("#frmadv_content_" + content_id).find(".accordion").length < 2) return;
  if (!confirm("Are you really going to remove this accordion?")) return true;
  $(obj).parent().parent().parent().remove();
}

function frmadv_close_tab(){
  if ($(this).parent().parent().find("li").length < 2) return;
  if (!confirm("Are you really going to remove this tab?")) return true;
  $(this).parent().remove();
}

function frmadv_add_tab(){
  frmadv_add_tab_content($(this).attr("data-wizardid"));
}

function frmadv_remove_wizard(){
  if ($(".frmadv_wizard_ul li").length < 2) return;
  if (!confirm("Are you really going to remove this wizard?")) return true;
  $(this).parent().remove();
}

function select_wizard(e){
  e.preventDefault();
  var parent = $(".frmadv_wizard_ul");
  $(parent).find("li").removeClass("active");
  $(this).addClass("active");
  frmadv_select_wizard_content();
}

function generate_id(prefix = ""){
  var id = parseInt(Math.random() * 100000000);
  return prefix + id;
}