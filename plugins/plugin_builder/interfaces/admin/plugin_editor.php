<?php include_once '../../../../config/config.php'; ?>

<div class="main-body mt-1r mb-1r">
    <input type="text" id="plugin_name" value="<?php echo $_GET["id"];?>">
    <div class="row">
        <div class="col-12">
            <form action="" method="post">
                <div class="card">
                    <div class="card-header">
                    <h3 class="card-title"></h3>
                    <div class="card-tools">
                        <a href="/admin/plugins/plugin_builder/plugins" data-nsfw-filter-status="swf">&lt; Back to plugins</a>							
                    </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                    <h4>Editing Plugin - andreas</h4>
                    <ul class="nav nav-tabs" id="editor-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link" id="rest-api-tab" data-toggle="pill" href="#rest-api-interface" rol="tab" 
                                        aria-controls="rest-api-interface" aria-selected="true">Rest API</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="table-builder-tab" data-toggle="pill" href="#table-builder-interface" rol="tab" 
                                        aria-controls="table-builder-interface" aria-selected="true">Table Builder</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="database-script-tab" data-toggle="pill" href="#database-script-interface" rol="tab" 
                                        aria-controls="database-script-interface" aria-selected="true">Database Script</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="commits-tab" data-toggle="pill" href="#commits-interface" rol="tab" 
                                        aria-controls="commits-interface" aria-selected="true">Commits</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="setting-tab" data-toggle="pill" href="#setting-interface" rol="tab" 
                                        aria-controls="setting-interface" aria-selected="true">Setting</a>
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
                        <div class="tab-pane fade show" id="database-script-interface" role="tabpanel" aria-labelledby="database-script-tab">
                            <div class="card-body p-0">
                                Database Script
                            </div>
                        </div>
                        <div class="tab-pane fade show" id="commits-interface" role="tabpanel" aria-labelledby="commits-tab">
                            <div class="card-body p-0">
                                Commits
                            </div>
                        </div>
                        <div class="tab-pane fade show" id="rest-api-interface" role="tabpanel" aria-labelledby="rest-api-tab">
                            <div class="card-body p-0">
                                Setting
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

<script src="/plugins/plugin_builder/assets/plugins/js/rest_api_builder.js"></script>
<script src="/plugins/plugin_builder/assets/js/Sortable.js"></script>
<script src="/plugins/plugin_builder/assets/plugins/js/datatable.js"></script>