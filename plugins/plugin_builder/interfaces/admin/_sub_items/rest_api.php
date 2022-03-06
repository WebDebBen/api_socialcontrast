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