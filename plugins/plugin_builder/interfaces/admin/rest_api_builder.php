<?php include_once '../../../../config/config.php'; ?>
<input type="hidden" id="plugin_path" value="<?php  echo PLUGIN_PATH;?>">
<div class="main-body mt-1r mb-1r">
    <div class="row">
        <div class="col-md-12">
            <button class="btn btn-success hide" id="prev_btn">Prev</button>
            <button class="btn btn-success" id="next_btn">Next</button>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="mt-1r mb-1r" id="table-list">
                <div class="row mt-1r mb-1r">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input class="all-check" type="checkbox" id="all-table-check">
                            <label class="form-check-label table-label" for="all-table-check">Check/Uncheck All</label>
                        </div>
                    </div>
                </div>
                <div class="table-list" id="table-wrap"></div>
            </div>
            <div class="mt-1r mb-1r table-info hide" id="table-info"></div>
            <div class="mt-1r mb-1r statis-wrap hide" id="statis-wrap">
                <h4 id="selected_table"></h4>
                <button class="btn btn-primary mt-1r mb-1r" id="gen_btn">Generate</button>
                <div id="generate_result">
                    <h3 class="gen_status"></h3>
                    <p class="api_url"></p>
                </div>
            </div>
        </div>
    </div>

</div>
<script src="/plugins/plugin_builder/assets/js/rest_api_builder.js"></script>