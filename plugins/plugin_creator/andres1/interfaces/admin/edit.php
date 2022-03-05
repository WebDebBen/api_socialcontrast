<?php include_once '../../../../config/config.php'; ?>

<div class="main-body mt-1r mb-1r">
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
                    <div class="tab-content" id="editor-tabContent">
                        <div class="tab-pane fade show active" id="rest-api-interfaces" role="tabpanel" aria-labelledby="rest-api-tab">
                            <div class="card-body table-responsive p-0">
                                Rest API
                            </div>
                        </div>
                        <div class="tab-pane fade show active" id="table-builder-interfaces" role="tabpanel" aria-labelledby="table-builder-tab">
                            <div class="card-body table-responsive p-0">
                                Table Builder
                            </div>
                        </div>
                        <div class="tab-pane fade show active" id="database-script-interfaces" role="tabpanel" aria-labelledby="database-script-tab">
                            <div class="card-body table-responsive p-0">
                                Database Script
                            </div>
                        </div>
                        <div class="tab-pane fade show active" id="commits-interfaces" role="tabpanel" aria-labelledby="commits-tab">
                            <div class="card-body table-responsive p-0">
                                Commits
                            </div>
                        </div>
                        <div class="tab-pane fade show active" id="rest-api-interfaces" role="tabpanel" aria-labelledby="rest-api-tab">
                            <div class="card-body table-responsive p-0">
                                Setting
                            </div>
                        </div>
                    </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-header">
                    <div class="card-tools text-right">
                        <button type="submit" class="btn btn-primary" name="save_data" value="save">Save</button>
                    </div>
                    </div>
                </div>
                <!-- /.card -->
            </form>
        </div>
    </div>
</div>

