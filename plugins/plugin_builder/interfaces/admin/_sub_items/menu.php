<div class="row">
    <div class="col-md-12">
        <button type="button" class="btn btn-primary" id="add_menu_item">Add Menu</button>
    </div>
</div>

<div class="row mt-1r">
    <div class="col-md-12">
        <table class="table">
            <thead>
                <tr>
                    <td>ID</td>
                    <td>Parent</td>
                    <td>Name</td>
                    <td>Link</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody id="menu_list">
            </tbody>
        </table>
    </div>
</div>

<div class="modal column-detail-modal" tabindex="-1" role="dialog" id="menu-edit-modal">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="dtp_table_title_modal">Menu</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form class="form">
                <div class="modal-body" id="menu_edit_modal_body">
                    <div class="row mb-1r form" data-flag="false">
                        <label class="col-md-2 text-right">ID</label>
                        <div class="col-md-10">
                            <input type="text" placeholder="ID" class="form-control input-md modal_menu_input" id="modal_menu_id">
                        </div>
                    </div>
                    <div class="row mb-1r form" data-flag="false">
                        <label class="col-md-2 text-right">Parent</label>
                        <div class="col-md-10">
                            <input type="text" placeholder="Parent" class="form-control input-md modal_menu_input" id="modal_menu_parent">
                        </div>
                    </div>
                    <div class="row mb-1r form" data-flag="false">
                        <label class="col-md-2 text-right">Name</label>
                        <div class="col-md-10">
                            <input type="text" placeholder="Name" class="form-control input-md modal_menu_input" id="modal_menu_name">
                        </div>
                    </div>
                    <div class="row mb-1r form" data-flag="false">
                        <label class="col-md-2 text-right">Link</label>
                        <div class="col-md-10">
                            <input type="text" placeholder="Link" class="form-control input-md modal_menu_input" id="modal_menu_link">
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <input type="hidden" id="data-menu-id" value="-1"/>
                <button type="button" class="btn btn-primary" id="menu_save_record">Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>