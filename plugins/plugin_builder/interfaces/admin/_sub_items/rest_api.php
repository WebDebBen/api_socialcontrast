<div class="row">
    <div class="col-md-12">
        <ul class="nav nav-tabs" id="restapi-editor-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link" id="rest-api-generate-tab" data-toggle="pill" href="#rest-api-generate-interface" rol="tab" 
                            aria-controls="rest-api-generate-interface" aria-selected="true">Rest API Generate</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link active" id="rest-api-editor-tab" data-toggle="pill" href="#rest-api-editor-interface" rol="tab" 
                            aria-controls="rest-api-editor-interface" aria-selected="true">Rest API Edit</a>
            </li>
        </ul>
        <div class="tab-content px-1r" id="restapi-editor-tabContent">
            <div class="tab-pane fade show " id="rest-api-generate-interface" role="tabpanel" aria-labelledby="rest-api-generate-tab">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-success hide" type="button" id="api_prev_btn">Prev</button>
                            <button class="btn btn-success" type="button" id="api_next_btn">Next</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mt-1r mb-1r" id="api_table-list">
                                <div class="row mt-1r mb-1r">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input class="all-check" type="checkbox" id="api_all-table-check">
                                            <label class="form-check-label table-label" for="api_all-table-check">Check/Uncheck All</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-list" id="api_table-wrap"></div>
                            </div>
                            <div class="mt-1r mb-1r table-info hide" id="api_table-info"></div>
                            <div class="mt-1r mb-1r statis-wrap hide" id="api_statis-wrap">
                                <h4 id="api_selected_table"></h4>
                                <button class="btn btn-primary mt-1r mb-1r" type="button" id="api_gen_btn">Generate</button>
                                <div id="api_generate_result">
                                    <h3 class="gen_status"></h3>
                                    <p class="api_url"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade show active" id="rest-api-editor-interface" role="tabpanel" aria-labelledby="rest-api-editor-tab">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-md-12">
                            <?php include_once("rest_api_edit.php"); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>