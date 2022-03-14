<div class="row" style="align-items:flex-end">
    <div class="col-md-3">
        <div class="form-group">
            <label>Table Name</label>
            <select class="form-control" id="dt_tbname"></select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <button class="btn btn-default" type="button" id="dt_select_tb_btn">Select Table</button>
            <button class="btn btn-success hide" type="button" id="dt_update_tb_btn">Update Data Table</button>
        </div>
    </div>
    <div class="col-md-5 text-right">
        <div class="form-group">
            <button class="btn btn-default" type="button" id="dt_table_data_new">New</button>
            <button class="btn btn-primary" type="button" id="dt_import_excel">Import</button>
            <button class="btn btn-success" type="button" id="dt_export_excel">Export</button>
        </div>
    </div>
</div>

<div class="filter-wrap mt-1r" id="filter-wrap"></div>
<div class="row mt-2r">
    <div class="col-md-12" id="dt_table_wrap">
        <table cellpadding="0" cellspacing="0" class="display" id="dt_table_data" width="100%">
            <thead>
                <tr>
                </tr>
            </thead>
            <tbody id='dt_table_data_body'>
            </tbody>
        </table>
    </div>
</div>

<div class="modal column-detail-modal" tabindex="-1" role="dialog" id="dt-edit-modal">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="dt_table_title_modal">aabbcc Table</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form class="form">
                <div class="modal-body" id="dt_edit_modal_body">
                </div>
            </form>
            <div class="modal-footer">
                <input type="hidden" id="data-dt-id" value="-1"/>
                <button type="button" class="btn btn-primary" id="dt_save_record">Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>