<div class="row" style="align-items:flex-end">
    <div class="col-md-3">
        <div class="form-group">
            <label>Interface Name</label>
            <select class="form-control" id="ai_interfaces_select">
                <option value="_sub_items/rest_api" class="ai_origin">Rest API Generate</option>
                <option value="_sub_items/rest_api_edit" class="ai_origin">Rest API Edit</option>
                <option value="_sub_items/tables" class="ai_origin">Database Builder</option>
                <option value="_sub_items/forms" class="ai_origin">Form Builder</option>
                <option value="_sub_items/data_table" class="ai_origin">Datatable Builder</option>
                <option value="_sub_items/datatable_preview" class="ai_origin">Datatable Preview</option>
                <option value="_sub_items/data_tablequery" class="ai_origin">Datatable Query</option>
                <option value="_sub_items/database_script">Database Script</option>
                <option value="_sub_items/settings" class="ai_origin">Settings</option>
            </select>
        </div>
    </div>
    <div class="col-md-5">
        <div class="form-group">
            <button class="btn btn-default" type="button" id="admin_edit_select_tb">Select Interface</button>
            <button class="btn btn-primary" type="button" id="admin_edit_save_data">Save</button>
            <button class="btn btn-danger hide" type="button" id="admin_edit_delete_data">Delete</button>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <input type="text" class="form-control" id="ai_interface_name" placeholder="Interface Name">
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <button class="btn btn-primary" id="ai_interface_add_btn" type="button">Save New Interface</button>
        </div>
    </div>
</div>
<div class="row mt-1r">
    <div class="col-md-12">
        <textarea name="" id="admin_interface_area" cols="30" rows="10" class="form-control"></textarea>
    </div>
</div>