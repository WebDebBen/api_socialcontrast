<script src="//cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css"><script type="text/javascript" charset="utf-8" src="assets/js/apis/post_comment.js"></script>
<div class='main-body'>
	<h1 class="mt-1r">DataTables Editor <span>post_comment</span></h1>
	<div class="row mt-1r mb-1r">
		<div class="col-md-12">
			<button class="btn btn-success" id="post_comment_new">New</button>
			<button class="btn btn-success" id="export_excel">Export</button>
		</div>
	</div>
	<div class="row mt-2r">
		<div class="col-md-12">
		<table cellpadding="0" cellspacing="0" border="0" class="display" id="post_comment_table" width="100%">
			<thead><tr>
				<th>Post Id</th>
				<th>Photo</th>
				<th>Description</th>
				<th>Action</th>
			</tr></thead>
			<tbody id='post_comment_body'>
			</tbody>
		</table>
		</div>
	</div>
</div>
<div class="modal column-detail-modal" tabindex="-1" role="dialog" id="edit-modal">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">post_comment Table</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form class="form">
			<div class="modal-body">
				<div class="form-group row">
					<label for="field-default-value" class="col-sm-2 col-form-label text-right">Post Id</label>
					<div class="col-sm-10">
					<select class='form-control' data-reffield='id' data-reftable='posts' data-table='post_comment' data-type='relation' id='post_comment_field_post_id'>
					</select>				</div>
			</div>
				<div class="form-group row">
					<label for="field-default-value" class="col-sm-2 col-form-label text-right">Photo</label>
					<div class="col-sm-10">
					<div id="post_comment_field_photo_upload" data-type="file">Select File</div>					<button class="btn btn-primary" type="button" id="post_comment_field_photo_btn">Upload</button>				</div>
			</div>
				<div class="form-group row">
					<label for="field-default-value" class="col-sm-2 col-form-label text-right">Description</label>
					<div class="col-sm-10">
					<textarea class="form-control" data-type="string" id="post_comment_field_description"></textarea>
				</div>
			</div>
			</div>
		</form>
	<div class="modal-footer">
			<input type="hidden" id="data-id" value="-1"/>
			<button type="button" class="btn btn-primary" id="save_record">Save</button>
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
