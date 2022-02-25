<?php include_once '../../../../config/config.php'; ?>

<input type="hidden" id="plugin_path" value="<?php  echo PLUGIN_PATH;?>">
<div class="main-body mt-1r mb-1r">
    <div class="row">
        <div class="col-md-2 text-right"><b>Table/Form Name</b></div>
        <div class="col-md-1">
            <input type="text" class="form-control" id="tb_frm_name">
        </div>
        <div class="col-md-9">
            <button class="btn btn-default" id="new_table">New Form</button>
            <button class="btn btn-primary" id="load_table">Load Table</button>
            <button class="btn btn-primary" id="load_form">Load Form</button>
            <button class="btn btn-info" id="preview_form">Preview Form</button>
            <button class="btn btn-success" id="save_form">Save Form</button>
        </div>
    </div>

    <div class="row mt-1r">
        <div class="comp-wrap overflow-x-hidden" data-visible="true">
            <div class="accor_left" id="accor_left"><i class="fa fa-align-justify"></i></div>
            <form class="form-horizontal flex-comp" id="components">
                <fieldset>
                    <div class="tab-content">
                        <label class="label-control">Elements</label>
                        <div class="tab-pane active" id="1">
                            <div class="form-group component" data-id="text_obj">
                                <i class="fa fa-align-justify"></i>Text
                            </div>
                            <div class="form-group component" data-id="textarea_obj">
                                <i class="fa fa-indent"></i>Text Area
                            </div>
                            <div class="form-group component" data-id="ckeditor_obj">
                                <i class="fa fa-pen"></i>Editor
                            </div>
                            <div class="form-group component" data-id="date_obj">
                                <i class="fa fa-calendar"></i>Date
                            </div>
                            <div class="form-group component" data-id="file_obj">
                                <i class="fa fa-file"></i>File
                            </div>
                            <div class="form-group component" data-id="image_obj">
                                <i class="fa fa-image"></i>Image
                            </div>
                            <div class="form-group component" data-id="hidden_obj">
                                <i class="fa fa-hidden"></i>Hidden
                            </div>
                            <div class="form-group component" data-id="paragraph_obj">
                                <i class="fa fa-paragraph"></i>Paragraph
                            </div>
                            <div class="form-group component" data-id="select_obj">
                                <i class="fa fa-play"></i>Select
                            </div>
                            <div class="form-group component" data-id="checkbox_obj">
                                <i class="fa fa-check fa-checkbox"></i>Checkbox
                            </div>
                            <div class="form-group component" data-id="radio_obj">
                                <i class="fa fa-dot-circle"></i>Radio
                            </div>
                            <div class="form-group component" data-id="condition_start">
                                <i class="fa fa-filter"></i>Condition Start
                            </div>
                            <div class="form-group component" data-id="condition_end">
                                <i class="fa fa-filter"></i>Condition End
                            </div>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
        <div class="ele-wrap" data-length="7">
            <div class="clearfix">
                <div id="build">
                    <div class="tabbable">
                        <ul class="nav nav-tabs" id="navtab">
                            <li><a href="#form_zone" data-toggle="tab" class="active">Form Zone</a></li>
                            <li><a href="#html_zone" data-toggle="tab">HTML Result</a></li>
                            <li><a href="#json_zone" data-toggle="tab">Json Result</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="form_zone">
                                <form id="target" class="form-horizontal">
                                    <fieldset id="target_fieldset">
                                    <div id="legend" class="component" rel="popover" title="Form Title" trigger="manual"
                                        data-content="
                                        <form class='form'>
                                        <div class='form-group col-md-12'>
                                            <label class='control-label'>Title</label> <input class='form-control' type='text' name='title' id='text'>
                                            <hr/>
                                            <button class='btn btn-info'>Save</button><button class='btn btn-danger'>Cancel</button>
                                        </div>
                                        </form>" data-html="true">
                                    </div>
                                    </fieldset>
                                </form>
                            </div>
                            <div class="tab-pane" id="html_zone">
                                <textarea id="source" class="col-md-12" readonly></textarea>
                            </div>
                            <div class="tab-pane" id="json_zone">JSON ZONE</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="prop-wrap pt-2r overflow-x-hidden" data-visible="true">
            <div class="accor_right" id="accor_right"><i class="fa fa-align-justify"></i></div>
            <div id="obj_detail_wrap" class="flex-comp">
            </div>
        </div>
    </div>
</div>

<div class="modal tb-frm-modal" tabindex="-1" role="dialog" id="tb_frm_modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Table/Form List</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <select class="form-control" id="tb_frm_list"></select>
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="select_list">Select</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal preview_modal" tabindex="-1" role="dialog" id="preview_modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Preview Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="priview_wrap">
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="/plugins/plugin_builder/assets/js/Sortable.js"></script>
<script src="/plugins/plugin_builder/assets/js/form_builder_new.js"></script>