<?php include_once '../../../../config/config.php'; ?>

<input type="hidden" id="plugin_path" value="<?php  echo PLUGIN_PATH;?>">

<div class="main-body mt-1r mb-1r">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"></h3>
                    <div class="card-tools">
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap salesman_table">
                        <thead>
                            <tr>
                                <th>System/Plugin</th>
                                <th>Name</th>
                                <th>View</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="plugin_tbody" id="plugin_tbody">
                            <tr class="add_tr">
                                <td>
                                    <select class="form-control" id="new_plugin_type">
                                        <option value="system">System</option>
                                        <option value="plugin">Plugin</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" id="new_plugin"></td>
                                <td><button type="button" class="btn btn-success add-row" id="save_new_plugin">Add</button></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-header">
                    <div class="card-tools text-right">
                        <button type="submit" class="btn btn-primary" name="save_data" value="save">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/plugins/plugin_builder/assets/js/plugins.js"></script>