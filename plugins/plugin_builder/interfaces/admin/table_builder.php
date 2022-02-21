<?php include_once '../../../../config/config.php'; ?>
<input type="hidden" id="plugin_path" value="<?php  echo PLUGIN_PATH;?>">

<div class="main-body mt-1r mb-1r">
    <div class="row">
        <div class="col-md-2">
            <h4>Table Select</h4>
        </div>
        <div class="col-md-3">
            <select class="form-control" id="table_list_sel">
                <option value="test">test</option>
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-success" id="select_table">Select Table</button>
            <button class="btn btn-primary" id="check_table">Preview Table</button>
        </div>
    </div>
    <hr>
    <div class="row mt-1r">
        <div class="col-md-12">
            <h4>Server and Database</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-md-1">Server Type : </div>
        <div class="col-md-1"><label>PHP</div>
        <div class="col-md-1">Database type :</div>
        <div class="col-md-1"><label>My SQL</div>
    </div>
    <div class="row mt-1r mb-1r align-center">
        <div class="col-md-1">Table Name : </div>
        <div class="col-md-2">
            <input type="text" class="form-control" id="table-name-input">
        </div>
        <div class="col-md-1">Primary Key : </div>
        <div class="col-md-2">
            <input type="text" class="form-control" id="primary-key-input" value="id">
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12"><h4>Form Table</h4></div>
    </div>
    <div class="row">
        <div class="col-md-12" id="table-property">
        </div>
    </div>
    <div class="row mt-24">
        <div class="col-md-12" id="table-field-add">
            <button class="form-control btn btn-success" id="add-table-prop-item-btn"> + </button>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12"><h5>Action</h5></div>
    </div>
    <div class="row mt-24">
        <div class="col-md-6">
            <button class="btn btn-success" id="run_btn">Run Now</button>
            <button class="btn btn-primary" id="save_btn">Save Table</button>
        </div>
        <div class="col-md-6">
            <label class="mr-1r">View: </label>
            <button class="btn btn-primary" id="gen_sql">SQL</button>
            <button class="btn btn-primary" id="gen_html">HTML</button>
            <button class="btn btn-primary" id="gen_javascript">Javascript</button>
            <button class="btn btn-primary" id="gen_php">PHP</button>
            <button class="btn btn-primary" id="gen_json">JSON</button>
        </div>
    </div>
</div>

<div class="modal column-detail-modal" tabindex="-1" role="dialog" id="generated-modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Generated</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="generated_content">
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>

<div class="modal column-detail-modal" tabindex="-1" role="dialog" id="column-detail-modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Field Configuration</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form">
                <div class="modal-body">
                    <div class="row">
                        <h5>Field Name and Type</h5>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="field-title" class="col-sm-4 col-form-label">Title</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="field-title-md">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="field-column-name" class="col-sm-4 col-form-label">SQL Column Name</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="field-column-name-md">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="field-type" class="col-sm-4 col-form-label">Type</label>
                                <div class="col-sm-8">
                                    <select class="form-control" id="field-type-md">
                                        <option data-type="varchar" value="varchar(255)">Text</option>
                                        <option data-type="int" value="integer">Integer</option>
                                        <option data-type="double" value="double">Double</option>
                                        <option data-type="varchar" value="varchar(100)">Password</option>
                                        <option data-type="text" value="text">Text Area</option>
                                        <option data-type="varchar" value="varchar(300)">Image</option>
                                        <option data-type="tinyint" value="tinyint">Check</option>
                                        <option data-type="date" value="date">Date</option>
                                        <option data-type="datetime" value="datetime">Datetime</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="field-default-value" class="col-sm-4 col-form-label">Default Value</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="field-default-value-md">
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row">
                                <label for="table-list" class="col-sm-4 col-form-label">Refereance Table</label>
                                <div class="col-sm-8">
                                    <select class="form-control" id="table-list-md">
                                        <option value="">Select Table</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="field-list" class="col-sm-4 col-form-label">Reference Field</label>
                                <div class="col-sm-8">
                                    <select class="form-control" id="field-list-md">
                                        <option value="">Select Field</option>
                                    </select>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <h5>Validation</h5>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="field-default-value" class="col-sm-4 col-form-label">Required</label>
                                <div class="col-sm-8">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="field-required" id="required_yes" value="1" checked>
                                        <label class="form-check-label" for="required_yes">Yes</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="field-required" id="required_no" value="2" checked>
                                        <label class="form-check-label" for="required_no">No</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <h5>Show In</h5>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="field-default-value" class="col-sm-4 col-form-label">Table</label>
                                <div class="col-sm-8">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="table-show" id="table_yes" value="1" checked>
                                        <label class="form-check-label" for="table_yes">Yes</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="table-show" id="table_no" value="2" checked>
                                        <label class="form-check-label" for="table_no">No</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="field-default-value" class="col-sm-4 col-form-label">Editor</label>
                                <div class="col-sm-8">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="editor-show" id="editor_yes" value="1" checked>
                                        <label class="form-check-label" for="editor_yes">Yes</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="editor-show" id="editor_no" value="2" checked>
                                        <label class="form-check-label" for="editor_no">No</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="save_config">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="hide" id="table-prop-item-template">
    <div class="table-prop-item mt-1r">
        <div class="fa fa-arrows-alt"></div>
        <div class="field-props-wrap">
            <div class="field-prpos">
                <div class="field-title">
                    <label class="">Title</label>
                    <input type="text" class="form-control field-title-input">
                </div>
                <div class="field-type ml-1r mr-1r">
                    <label class="">Type</label>
                    <select class="form-control field-type-input">
                        <option data-type="varchar" value="varchar(255)">Text</option>
                        <option data-type="int" value="integer">Integer</option>
                        <option data-type="double" value="double">Double</option>
                        <option data-type="varchar" value="varchar(100)">Password</option>
                        <option data-type="text" value="text">Text Area</option>
                        <option data-type="varchar" value="varchar(300)">Image</option>
                        <option data-type="tinyint" value="tinyint">Check</option>
                        <option data-type="date" value="date">Date</option>
                        <option data-type="datetime" value="datetime">Datetime</option>
                    </select>
                </div>
                <div class="field-required ml-1r mr-1r">
                    <label class="full-width">Required</label>
                    <input type="checkbox" class="field-required-input mt-10" checked>
                </div>
                <div class="field-title">
                    <label class="">Default Value</label>
                    <input type="text" class="form-control field-default-value-input">
                </div>
                <div class="field-required ml-1r mr-1r">
                    <label class="full-width ">Show Table</label>
                    <input type="checkbox" class="field-show-table-input mt-10" checked>
                </div>
                <div class="field-required ml-1r mr-1r">
                    <label class="full-width">Show Editor</label>
                    <input type="checkbox" class="field-show-editor-input mt-10" checked>
                </div>
                <div class="field-action">
                    <button class="btn btn-danger mt-24 remove-table-prop-item">Remove</button>
                </div>
            </div>
            <div class="field-add-props">
                <a href="javascript:;" class="add-props-edit">
                    Refrence Info - Table: 
                    <span class="reference_table_span font-bold">None</span>
                    , Field: 
                    <span class="reference_field_span font-bold">None</span>
                </a>
            </div>
        </div>
    </div>
</div>
<script src="/plugins/plugin_builder/assets/js/Sortable.js"></script>
<script src="/plugins/plugin_builder/assets/js/datatable.js"></script>