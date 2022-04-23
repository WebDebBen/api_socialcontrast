<div class="row">
    <div class="col-md-2">
        <div class="field-title">
            <label class="">Datatable List</label>
            <div><select class="form-control" id="dtp_datatable_list"></select></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="field-title">
            <label class="full-width">Hidden Columns</label>
            <div><select class="form-control" id="dtp_hidden_columns" multiple="true"></select></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="field-title">
            <label class="full-width">Advanced Search Form</label>
            <div><select class="form-control" id="dtp_adbanced_search_select" multiple="true"></select></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="field-title">
            <label class="full-width">Add/Edit Form</label>
            <div><select class="form-control" id="dtp_add_edit_select" multiple="true"></select></div>
        </div>
    </div>
</div>
<div class="row mt-1r">
    <div class="col-md-2">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="dtp_allow_add_chk" checked="true">
            <label class="form-check-label" for="dtp_allow_add_chk">Allow Add</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="dtp_allow_edit_chk" checked="true">
            <label class="form-check-label" for="dtp_allow_edit_chk">Allow Edit</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="dtp_allow_advanced_search_chk" checked="true">
            <label class="form-check-label" for="dtp_allow_delete_chk">Allow Advanced Search</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="dtp_allow_delete_chk" checked="true">
            <label class="form-check-label" for="dtp_allow_delete_chk">Allow Delete</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="dtp_allow_export_chk" checked="true">
            <label class="form-check-label" for="dtp_allow_export_chk">Allow Export</label>
        </div>
    </div>
    <div class="col-md-2">
        <button class="form-control btn btn-primary" id="dtp_generate_table" type="button">Generate Table</button>
    </div>
</div>
<div class="row mt-1r">
    <div class="col-md-12">
        <textarea class="form-control tablequery_code_area" id="dtp_datatable_php" rows="11"></textarea>
    </div>
</div>

<div class="filter-wrap mt-1r" id="dtp-filter-wrap"></div>
<div class="row">
    <div class="col-md-12 text-right">
        <button class="btn btn-success" id="add-dtp-btn" type="button">Add</button>
    </div>
</div>
<div class="row mt-1r">
    <div class="col-md-12">
        <div id="dpt_datatable_buttons"></div>
        <div id="dtp_datatable_area" class="dtp_datatable_area"></div>
    </div>
</div>

<div class="modal column-detail-modal" tabindex="-1" role="dialog" id="dtp-edit-modal">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="dtp_table_title_modal">Table</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form class="form">
                <div class="modal-body" id="dtp_edit_modal_body">
                </div>
            </form>
            <div class="modal-footer">
                <input type="hidden" id="data-dtp-id" value="-1"/>
                <button type="button" class="btn btn-primary" id="dtp_save_record">Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>