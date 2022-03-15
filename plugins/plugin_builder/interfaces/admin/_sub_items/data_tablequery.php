<div class="row">
    <div class="col-md-1 text-right">
        <label class="form-label">Query List</label>
    </div>
    <div class="col-md-2">
        <select class="form-control" id="tq_query_list"></select>
    </div>
    <div class="col-md-1 mb-1r">
        <button class="btn btn-default" id="load_tq_query" type="button">Load Query</button>
    </div>
    <div class="col-md-12">
        <textarea name="" id="tablequery_code_area" class="tablequery_code_area form-control"></textarea>
    </div>
</div>

<div class="row mt-1r">
    <div class="col-md-8 mb-1r text-left">
        <button class="btn btn-primary" id="run_tq_query" type="button">Run Query</button>
    </div>
    <div class="col-md-2">
        <input type="text" class="form-control" id="tq_query_name">
    </div>
    <div class="col-md-2">
        <button class="btn btn-success" type="button" id="tq_save_query">Save Query</button>
    </div>
</div>

<div class="row mt-1r ">
    <div class="col-md-12" id="tablequery-wrap">
    </div>
</div>