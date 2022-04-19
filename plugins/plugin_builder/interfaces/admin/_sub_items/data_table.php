<!-- <div class="row" style="align-items:flex-end">
    <div class="col-md-3">
        <div class="form-group">
            <label>Datatable List</label>
            <select class="form-control" id="dt_tbname"></select>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <button class="btn btn-default" type="button" id="dt_select_tb_btn">Select Datatable</button>
            <button class="btn btn-success hide" type="button" id="dt_update_tb_btn">Update Datatable</button>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group dt_columns_visibility">
            <div class="dt_column_title">Columns Visibility</div>
            <ul class="dt_columns_ul">
            </ul>
        </div>
    </div>
    <div class="col-md-4 text-right">
        <div class="form-group">
            <button class="btn btn-default" type="button" id="dt_table_data_new">Add</button>
            <button class="btn btn-default" type="button" id="dt_table_data_adv_search">Advanced Search</button>
            <button class="btn btn-primary" type="button" id="dt_import_excel">Import</button>
            <button class="btn btn-success" type="button" id="dt_export_excel">Export</button>
        </div>
    </div>
</div> -->
<div class="row mb-1r">
    <div class="col-md-2 text-right">
        <label>Datatable List</label>
    </div>
    <div class="col-md-3">
        <select id="dt_datatable_list" class="form-control"></select>
    </div>
    <div class="col-md-1">
        <button type="button" class="btn btn-default" id="dt_datatable_load">Load</button>
    </div>
    <div class="col-md-6 text-right">
        <button type="button" class="btn btn-primary" id="dt_datatable_preview">Preview</button>
    </div>
</div>
<div class="row mb-1r">
    <div class="col-md-2 text-right">
        <label>Table/Views List</label>
    </div>
    <div class="col-md-3">
        <select id="dt_table_view_list" class="form-control"></select>
    </div>
    <div class="col-md-1">
        <button type="button" class="btn btn-default" id="dt_table_view_load">Load</button>
    </div>
</div>
<div class="row mb-1r">
    <div class="col-md-12" id="dt_columns_list">
    </div>
</div>
<div class="row mb-1r">
    <div class="col-md-12">
        <button type="button" class="btn btn-primary form-control" id="add_dtn_new_column">+</button>
    </div>
</div>
<div class="row mb-1r">
    <div class="col-md-2 text-right"><label>Datatable Name</label></div>
    <div class="col-md-2">
        <input type="text" class="form-control" id="dtn_datatable_name">
    </div>
    <div class="col-md-1">
        <button type="button" class="btn btn-primary" id="dtn_datatable_save_btn">Save</button>
    </div>
</div>
<input type="hidden" id="dtn_table_view_origin_name">
<div class="hide" id="dtn-datatb_table-prop-item-template">
    <div class="table-prop-item mt-1r">
        <div class="fa fa-arrows-alt"></div>
        <div class="field-props-wrap">
            <div class="field-prpos">
                <div class="field-title">
                    <label class="">Label</label>
                    <input type="text" class="form-control field-title-input">
                </div>
                <div class="field-type ml-1r mr-1r">
                    <label class="">Type</label>
                    <select class="form-control field-type-input">
                        <option data-type="varchar" value="varchar(255)">Text</option>
                        <option data-type="varchar" value="varchar(200)">Medium Text</option>
                        <option data-type="int" value="int(11)">Integer</option>
                        <option data-type="double" value="double">Double</option>
                        <option data-type="varchar" value="varchar(100)">Password</option>
                        <option data-type="text" value="text">Text Area</option>
                        <option data-type="varchar" value="varchar(300)">Image</option>
                        <option data-type="tinyint" value="tinyint">Check</option>
                        <option data-type="date" value="date">Date</option>
                        <option data-type="datetime" value="datetime">Datetime</option>
                    </select>
                </div>
                <div class="field-title">
                    <label class="">Default Value</label>
                    <input type="text" class="form-control field-default-value-input">
                </div>
                <div class="field-required ml-1r mr-1r">
                    <label class="full-width ">Visible</label>
                    <input type="checkbox" class="field-visible-table-input mt-10" checked>
                </div>
                <div class="field-required ml-1r mr-1r">
                    <label class="full-width">Show In Advanced Search</label>
                    <input type="checkbox" class="field-show-advanced-search-input mt-10" checked>
                </div>
                <div class="field-action">
                    <button class="btn btn-danger mt-24 remove-table-prop-item" type="button">Remove</button>
                </div>
            </div>
        </div>
    </div>
</div>