var formBuilder;
$(document).ready(function(){
    init_table_list();
    $("#select_btn").on("click", select_table );
    formBuilder = $("#form_builder_wrap").formBuilder({
        formData: '[{"type":"text", "label":"Text Input", "className": "form-control"}]',
        dataType: 'json'
    }).data("formBuilder");
    //formBuilder.actions.clearFields();
});

function select_table(){
    var table_name = $("#table_list_select").val();
    $.ajax({
        url: "/plugins/plugin_builder/include/classes/form_builder",
        data: {
            type: "table_info",
            table_name: table_name
        },
        type: "post",
        dataType: "json",
        success: function(res ){
            rebuildForm(res );
        }
    });
}
/*{"type":"text", "label":"Text Input", "className": "form-control"}
<select class="form-control field-type-input">
                        <option value="varchar(255)">Text</option>
                        <option value="integer">Integer</option>
                        <option value="double">Double</option>
                        <option value="password">Password</option>
                        <option value="text">Text Area</option>
                        <option value="boolean">Check</option>
                        <option value="date">Date</option>
                        <option value="datetime">Datetime</option>
                    </select>
                    */
function rebuildForm(res ){
    /*$("#table_name").val(res["table_name"]);
    data = [];
    for(var i = 0; i < res["columns"].length; i++ ){
        var item = res["columns"][i];
        var type = "text";
        if (item["data_type"] == "int"){
            type = "number"
        }else if(item["data_type"] == "date" || item["data_type"] == "datetime" ){
            type = "datetime";
        }else if(item["data_type"] == "" )
    }*/
}

function init_table_list(){
    $.ajax({
        url: "/plugins/plugin_builder/include/classes/form_builder",
        data:{
            type: "table_list"
        },
        type: "post",
        dataType: "json",
        success: function(res ){
            for(var i = 0; i < res.length; i++ ){
                $("<option>").attr("value", res[i]).text(res[i]).appendTo($("#table_list_select"));
            }
        }
    });
}