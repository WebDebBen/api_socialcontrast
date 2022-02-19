<script src="//cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css"><script src="http://hayageek.github.io/jQuery-Upload-File/4.0.11/jquery.uploadfile.min.js"></script>;<link href="http://hayageek.github.io/jQuery-Upload-File/4.0.11/uploadfile.css" rel="stylesheet"><script type="text/javascript" charset="utf-8" src="assets/js/apis/.js"></script>
<div class='main-body'>
	<h1 class="mt-1r">DataTables Editor <span></span></h1>
	<div class="row mt-1r mb-1r"><div class="col-md-12"><button class="btn btn-success" id="_new">New</button><button class="btn btn-success" id="export_excel">Export</button></div></div>
	<div class="row mt-2r">
		<div class="col-md-12">
		<table cellpadding="0" cellspacing="0" border="0" class="display" id="_table" width="100%">
			<thead><tr>
				<th>Action</th>
			</tr></thead>
			<tbody id='_body'>
			</tbody>
		</table>
		</div>
	</div>
</div>
<div class="modal column-detail-modal" tabindex="-1" role="dialog" id="edit-modal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"> Table</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form class="form">
			<div class="modal-body">
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
