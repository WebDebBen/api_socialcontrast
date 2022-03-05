function convertToString(input ){
    if(input ){
        if(typeof input === "string"){
            return input;
        }
        return String(input);
    }
    return "";
}
function toWords(input ){
    input  = convertToString(input );
    var regex = /[A-Z\xC0-\xD6\xD8-\xDE]?[a-z\xDF-\xF6\xF8-\xFF]+|[A-Z\xC0-\xD6\xD8-\xDE]+(?![a-z\xDF-\xF6\xF8-\xFF])|\d+/g;
    return input.match(regex);
}

function toCamelCase(inputArray){
    var result = "";
    for(var i = 0; i < inputArray.length; i++ ){
        var currentStr = inputArray[i];
        var tempStr = currentStr.toLowerCase();
        tempStr = tempStr.substr(0,1).toUpperCase() + tempStr.substr(1);
        if (i == (inputArray.length - 1)){
            result += tempStr;
        }else{
            result += tempStr + "_";
        }
    }
    return result;
}

function toCamleCaseString(input ){
    let words = toWords(input);
    return toCamelCase(words );
}

function set_relation_table_data(obj_id, ref_table, ref_field ){
	$.ajax({
		url: "/plugins/plugin_builder/include/classes/table_generate.php",
		data:{
            type: "table_data",
			obj_id: obj_id,
			ref_table: ref_table,
            ref_field: ref_field
		},
		type: "post",
		dataType: "json",
		success: function(data ){
			if (data["status"] == "success"){
				var rs = data["rs"];
                var table_info = data["table_info"];
                var columns = table_info["columns"];
				for (var i = 0; i < rs.length; i++){
					var item = rs[i];
					var str = "";

					for (var j = 0; j < columns.length; j++ ){
						var cell = item[columns[j]["column_name"]];
						str += " - " + cell;
					}
                    $("<option>").attr("value", item[ref_field]).html(str ).appendTo($("#" + obj_id ));
				}
			}
		}
	});
}