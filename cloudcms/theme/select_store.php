<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Gevorest POS | Select Store</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="cloudcms/theme/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="cloudcms/theme/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="cloudcms/theme/dist/css/adminlte.min.css">
  
  <!-- jQuery -->
<script src="cloudcms/theme/plugins/jquery/jquery.min.js"></script>
</head>
<style>
@media (min-width: 1200px){
.container, .container-lg, .container-md, .container-sm, .container-xl {
    max-width: 100%;
    width: 1140px;
}
}
</style>
<body class="hold-transition login-page">
<div class="wrapper">
<form id="select_store_form" action="index.php" method="post">
<input type="hidden" name="action" value="select_store">
<section class="content">
      <div class="container">
      <div class="login-logo">
    <a href="index.php"><b>Gevorest</b>POS</a>
  </div>
        <div class="row">
          <!-- left column -->
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Select Store</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
             <div class="card-body">
                <div class="form-group">
                <?php
                	$items = new Store($db);
                	$items->records_per_page = 1000;
    				$items->page = 1;
    				$response = json_decode($items->getStore());
    				foreach($response->records as $store){
    					if(count($privileges->store_dependencies) > 0){
    						$is_checked = '';
    						if(count($privileges->store_dependencies) == 1){
    							$is_checked = 'checked';
    						}
    						foreach($privileges->store_dependencies as $dependencystore){
    							if($dependencystore->store_id == $store->id){
    								echo '<div class="form-check">
                    					<input class="form-check-input store_id" type="radio" name="store_id" id="stores_'.$store->id.'" value="'.$store->id.'" '.$is_checked.' onclick="javascript:check_form()">
                    					<label for="stores_'.$store->id.'" class="form-check-label">'.$store->name.'</label>
                    				</div>';
    							
    							}
    						}
    					}
    					else{
    						echo '<div class="form-check">
                    			<input class="form-check-input store_id" type="radio" name="store_id" id="stores_'.$store->id.'" value="'.$store->id.'" onclick="javascript:check_form()">
                    			<label for="stores_'.$store->id.'" class="form-check-label">'.$store->name.'</label>
                    		</div>';
    					}
    					
    				}
                ?>
                  </div>
              </div>
            </div>
            <!-- /.card -->
          </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-6">
            <!-- Form Element sizes -->
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Select Salesman</h3>
              </div>
              <div class="card-body">
                <div class="form-group">
                <?php
                // echo '<pre>';
//                 print_r($_SESSION);
//                 echo '</pre>';
                $items = new Salesman($db);
    			$items->records_per_page = 1000;
    			$items->page = 1;
    			$items->search_fields->id = $_SESSION['login']['salesman_id'];
    			
    			$response = json_decode($items->getSalesman());
    				foreach($response->records as $salesman){
    					$is_checked = '';
    					if($salesman->id == $_SESSION['login']['salesman_id']){
    						$is_checked = 'checked';
    					}
    					echo '<div class="form-check">
                    			<input class="form-check-input" type="radio" id="salesman_id_'.$salesman->id.'" name="salesman_id" value="'.$salesman->id.'" '.$is_checked.' onclick="javascript:check_form()">
                    			<label for="salesman_id_'.$salesman->id.'" class="form-check-label">'.$salesman->name.'</label>
                    		</div>';
    				}
                ?>
                
                  </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
</form>    
</div>

<script>
// select_store_form
	function check_form(){
		var store_id = '';
		if($("input[name='store_id']:checked").val()){
			store_id = $("input[name='store_id']:checked").val();
		}
		var salesman_id = '';
		if($("input[name='salesman_id']:checked").val()){
			salesman_id = $("input[name='salesman_id']:checked").val();
		}
        if(store_id != '' && salesman_id != ''){
        	$('#select_store_form').submit();
        }
        return false;
	}
	$( document ).ready(function() {
    check_form();
});
	
</script>


<!-- Bootstrap 4 -->
<script src="template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="template/dist/js/adminlte.min.js"></script>
</body>
</html>
