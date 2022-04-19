<?php include_once '../../../../config/config.php'; ?>
<div class="main-body mt-1r mb-1r">
    <input type="hidden" id="plugin_name" value="<?php echo $_GET["module"];?>">
    <div class="row">
        <div class="col-12">
            <form action="" method="post">
                <div class="card">
                    <div class="card-header">
                    <h3 class="card-title"></h3>
                    <div class="card-tools">
                        <a href="/admin/plugins/<?php echo $_GET["id"];?>/plugins" data-nsfw-filter-status="swf">&lt; Back to plugins</a>							
                    </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                    <h4>Editing Plugin - andreas</h4>
                    <ul class="nav nav-tabs" id="editor-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="rest-api-tab" data-toggle="pill" href="#rest-api-interface" rol="tab" 
                                        aria-controls="rest-api-interface" aria-selected="true">Rest API</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link active" id="rest-api-edit-tab" data-toggle="pill" href="#rest-api-edit-interface" rol="tab" 
                                        aria-controls="rest-api-edit-interface" aria-selected="true">Rest API Edit</a>
                        </li> -->
                        <li class="nav-item">
                            <a class="nav-link" id="table-builder-tab" data-toggle="pill" href="#table-builder-interface" rol="tab" 
                                        aria-controls="table-builder-interface" aria-selected="true">Database Builder</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="form-builder-tab" data-toggle="pill" href="#form-builder-interface" rol="tab" 
                                        aria-controls="form-builder-interface" aria-selected="true">Form Builder</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="form-builder-adv-tab" data-toggle="pill" href="#form-builder-adv-interface" rol="tab" 
                                        aria-controls="form-builder-adv-interface" aria-selected="true">Form Builder Advanced</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="data-table-tab" data-toggle="pill" href="#data-table-interface" rol="tab" 
                                        aria-controls="data-table-interface" aria-selected="true">Datatable Builder</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="data-table-peview-tab" data-toggle="pill" href="#data-table-preview-interface" rol="tab" 
                                        aria-controls="data-table-preview-interface" aria-selected="true">Datatable Preview</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="data-tablequery-tab" data-toggle="pill" href="#data-tablequery-interface" rol="tab" 
                                        aria-controls="data-tablequery-interface" aria-selected="true">Datatable Query</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="database-script-tab" data-toggle="pill" href="#database-script-interface" rol="tab" 
                                        aria-controls="database-script-interface" aria-selected="true">Database Script</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="menu-tab" data-toggle="pill" href="#menu-interface" rol="tab" 
                                        aria-controls="menu-interface" aria-selected="true">Menu</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="admin-interface-tab" data-toggle="pill" href="#admin-interface" rol="tab" 
                                        aria-controls="admin-interface" aria-selected="true">Edit Interface</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="commits-tab" data-toggle="pill" href="#commits-interface" rol="tab" 
                                        aria-controls="commits-interface" aria-selected="true">Commits</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="settings-tab" data-toggle="pill" href="#settings-interface" rol="tab" 
                                        aria-controls="settings-interface" aria-selected="true">Settings</a>
                        </li>
                    </ul>
                    <div class="tab-content px-1r" id="editor-tabContent">
                        <div class="tab-pane fade show active" id="rest-api-interface" role="tabpanel" aria-labelledby="rest-api-tab">
                            <div class="card-body p-0">
                                <div class="row">
                                    <div class="col-md-12">
                                        <?php include_once("_sub_items/rest_api.php"); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade show" id="table-builder-interface" role="tabpanel" aria-labelledby="table-builder-tab">
                            <div class="card-body p-0">
                                <?php include_once("_sub_items/tables.php"); ?>
                            </div>
                        </div>
                        <div class="tab-pane fade show" id="form-builder-interface" role="tabpanel" aria-labelledby="form-builder-tab">
                            <div class="card-body p-0">
                                <?php include_once("_sub_items/forms.php"); ?>
                            </div>
                        </div>
                        <div class="tab-pane fade show" id="form-builder-adv-interface" role="tabpanel" aria-labelledby="form-builder-adv-tab">
                            <div class="card-body p-0">
                                <?php include_once("_sub_items/form_builder_adv.php"); ?>
                            </div>
                        </div>
                        <div class="tab-pane fade show" id="data-table-interface" role="tabpanel" aria-labelledby="data-table-tab">
                            <div class="card-body p-0">
                                <?php include_once("_sub_items/data_table.php"); ?>
                            </div>
                        </div>
                        <div class="tab-pane fade show" id="data-table-preview-interface" role="tabpanel" aria-labelledby="data-table-preview-tab">
                            <div class="card-body p-0">
                                <?php include_once("_sub_items/datatable_preview.php"); ?>
                            </div>
                        </div>
                        <div class="tab-pane fade show" id="data-tablequery-interface" role="tabpanel" aria-labelledby="data-tablequery-tab">
                            <div class="card-body p-0">
                                <?php include_once("_sub_items/data_tablequery.php"); ?>
                            </div>
                        </div>
                        <div class="tab-pane fade show" id="database-script-interface" role="tabpanel" aria-labelledby="database-script-tab">
                            <div class="card-body p-0">
                                <?php include_once("_sub_items/database_script.php"); ?>
                            </div>
                        </div>
                        <div class="tab-pane fade show" id="menu-interface" role="tabpanel" aria-labelledby="menu-tab">
                            <div class="card-body p-0">
                                <?php include_once("_sub_items/menu.php"); ?>
                            </div>
                        </div>
                        <div class="tab-pane fade show" id="admin-interface" role="tabpanel" aria-labelledby="menu-tab">
                            <div class="card-body p-0">
                                <?php include_once("_sub_items/admin_interface.php"); ?>
                            </div>
                        </div>
                        <div class="tab-pane fade show" id="commits-interface" role="tabpanel" aria-labelledby="commits-tab">
                            <div class="card-body p-0">
                                <?php include_once("_sub_items/commits.php"); ?>
                            </div>
                        </div>
                        <div class="tab-pane fade show" id="settings-interface" role="tabpanel" aria-labelledby="settings-tab">
                            <div class="card-body p-0">
                                <?php include_once("_sub_items/settings.php"); ?>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                <!-- /.card -->
            </form>
        </div>
    </div>
</div>

<div class="editor_overlay hidden" id="editor_overlay"></div>
<div class="editor_code_mirror hidden" id="editor_code_mirror">
    <input type="hidden" name="" id="ol_plugin_name">
    <input type="hidden" name="" id="ol_script_name">
    <input type="hidden" id="ol_editor_type">
    <div class="editor_header">
        <span class="editor_header_title">Code Edit</span>
        <i class="fa fa-close editor_close_overlay" id="editor_close_overlay"></i>
    </div>
    <div class="editor_body">
        <textarea name="" id="editor_code_area" class="editor_code_area form-control"></textarea>
    </div>
    <div class="editor_footer">
        <button class="btn btn-primary" id="save_editor_overlay" type="button">Save</button>
        <button class="btn btn-danger" id="close_editor_overlay" type="button">Cancel</button>
    </div>
</div>


<div class="modal frmadv-preview-modal" tabindex="-1" role="dialog" id="frmadv-preview-modal">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="frmadv-preview-title">Advanced Form Preview</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form class="form">
                <div class="modal-body">
                    <div id="frmadv-preview-body"></div>
                    <div id="frmadv_preview_wizard_action" class="mt-1r">
                        <button class="btn btn-primary" id="frmadv_preview_wizard_prev" type="button">Prev</button>
                        <button class="btn btn-primary" id="frmadv_preview_wizard_next" type="button">Next</button>
                        <button class="btn btn-primary" id="frmadv_preview_wizard_finish" type="button">Finish</button>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <input type="hidden" id="data-frmadv-id" value="-1"/>
                <button type="button" class="btn btn-primary hide" id="dtp_save_record">Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="/plugins/plugin_builder/assets/js/Sortable.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.8.0/jszip.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.8.0/xlsx.js"></script>

<script src="/plugins/plugin_builder/assets/plugins/js/rest_api_builder.js"></script>
<script src="/plugins/plugin_builder/assets/plugins/js/datatable_builder.js"></script>
<script src="/plugins/plugin_builder/assets/plugins/js/database_script.js"></script>
<script src="/plugins/plugin_builder/assets/plugins/js/settings.js"></script>
<script src="/plugins/plugin_builder/assets/plugins/js/rest_api_editor.js"></script>
<script src="/plugins/plugin_builder/assets/plugins/js/commits.js"></script>
<script src="/plugins/plugin_builder/assets/plugins/js/form_builder_new.js"></script>
<script src="/plugins/plugin_builder/assets/plugins/js/datatable_new.js"></script>
<script src="/plugins/plugin_builder/assets/plugins/js/tablequery.js"></script>
<script src="/plugins/plugin_builder/assets/plugins/js/datatable_edit.js"></script>
<script src="/plugins/plugin_builder/assets/plugins/js/datatable_preview.js"></script>
<script src="/plugins/plugin_builder/assets/plugins/js/menu.js"></script>
<script src="/plugins/plugin_builder/assets/plugins/js/admin_interface.js"></script>
<script src="/plugins/plugin_builder/assets/plugins/js/form_builder_adv.js"></script>

<script>
    var editor;
    $(document).ready(function(){
        editor = CodeMirror.fromTextArea(document.getElementById("editor_code_area"), {
            lineNumbers: true,
            mode: "sql",
            indentUnit: 4,
            indentWithTabs: true
        });
        $("title").html("Editing Plugin - " + $("#plugin_name").val());
        $("#editor_overlay").on("click", hide_overlay );
        $("#editor_close_overlay").on("click", hide_overlay);
        $("#save_editor_overlay").on("click", save_plugin_editor );
        $("#close_editor_overlay").on("click", hide_overlay);
    });

    function save_plugin_editor(e){
        var plugin_name = $("#ol_plugin_name").val();
        var script_name = $("#ol_script_name").val();
        var type = $("#ol_editor_type").val();
        switch(type){
            case "database_script":
                save_database_script(plugin_name, script_name);
                break;
        }
    }

    function save_database_script(plugin_name, script_name ){
        var content = editor.getValue();
        $.ajax({
            url: "/plugins/plugin_builder/include/classes/plugin_database_script.php",
            data: {
                type: "save_ds_content",
                plugin_name: plugin_name,
                script_name: script_name,
                content: content
            },
            type: "post",
            dataType: "json",
            success: function(data ){
                if (data["status"] == "success"){
                    toastr.success("Successfuly");
                    hide_overlay();
                }else{
                    toastr.error("File not exists");
                }
            }
        });  
    }

    function hide_overlay(){
        $("#editor_overlay").addClass("hidden");
        $("#editor_code_mirror").addClass("hidden");
    }

    function show_overlay(){
        $("#editor_overlay").removeClass("hidden");
        $("#editor_code_mirror").removeClass("hidden");
    }
</script>