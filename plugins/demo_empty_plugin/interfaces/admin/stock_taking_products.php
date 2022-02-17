
<?php
		$items = new Product($db);
    	$response_categories = json_decode($items->getCategories());
    	$response_subcategories = json_decode($items->getSubCategories());
    	// $response_dimensions = json_decode($items->getDimensions());
//     	$response_colors = json_decode($items->getColors());
//     	$response_collections = json_decode($items->getCollections());
//     	$response_models = json_decode($items->getModels());
//     	$response_softness = json_decode($items->getSoftness());
    	
    	$response_dimensions = array();
    	$response_colors = array();
    	$response_collections = array();
    	$response_models = array();
    	$response_softness = array();
    	
    	// echo '<pre>';
//     	print_r($response_subcategories);
//     	echo '</pre>';
    	// $items = new Product($db);
//     	$items->search_fields->category = 'BED';
//     	$response_collections = json_decode($items->getCollections());
//     	echo '<pre>';
//     	print_r($response_collections);
//     	echo '</pre>';

// echo '<pre>';
// print_r($_GET);
// echo '</pre>';
?>
<style>
input, textarea {
  border: 1px solid #eeeeee;
  box-sizing: border-box;
  margin: 0;
  outline: none;
  padding: 10px;
}

input[type="button"] {
  -webkit-appearance: button;
  cursor: pointer;
}

input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
}

.input-group {
  clear: both;
  margin: 0px 0;
  position: relative;
}

.input-group input[type='button'] {
  background-color: #eeeeee;
  min-width: 38px;
  width: auto;
  transition: all 300ms ease;
}

.input-group .button-minus,
.input-group .button-plus {
  font-weight: bold;
  height: 38px;
  padding: 0;
  width: 38px;
  position: relative;
}

.input-group .quantity-field {
  position: relative;
  height: 38px;
  left: -6px;
  text-align: center;
  width: 62px;
  display: inline-block;
  font-size: 13px;
  margin: 0 0 5px;
  resize: vertical;
}

.button-plus {
  left: -13px;
}

input[type="number"] {
  -moz-appearance: textfield;
  -webkit-appearance: none;
}
</style>
<section class="content">
        <div class="container-fluid">
            <form action="#" onsubmit="return_product_results(1);return false;" id="search_form">
                <div class="card-header">
					<div class="card-tools text-right">
						<a href="<?php echo ROOT_URL;?>/admin/plugins/gevorest_stocktaking/stock_taking_scan/<?php echo $_GET['id'];?>" class="btn btn-primary">Continue Scan</a>
					</div>
				</div>
                <div class="row">
                    <div class="col-md-10 offset-md-1">
                        <div class="row">
                            <div class="col-6">
                            	<div class="form-group">
                                    <label>Store:</label>
                                    <select class="form-control" name="store_id" id="store_id" readonly>
                                    <?php
										$items = new Store($db);
										$items->records_per_page = 1000;
										$items->page = 1;
										$response = json_decode($items->getStore());
										foreach($response->records as $store){
											$is_selected = '';
											if($store->id == $_GET['id']){
												$is_selected = 'selected';
											}
											echo '<option '.$is_selected.' value="'.$store->id.'">'.$store->name.'</option>';
										}
									?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Search By:</label>
                                    <select class="form-control" name="search_by" id="search_by">
                                        <option selected="" value="barcode">Barcode</option>
                                        <option value="ext_code">Ext. Code</option>
                                        <option value="id">Code</option>
                                        <option value="name">Name</option>
                                        <option value="category">Category</option>
                                        <option value="collection">Collection</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
								<div class="form-group">
									<div class="input-group input-group-lg">
										<input type="search" class="form-control form-control-lg" placeholder="Type your keywords here" value="" name="search_term" id="search_term">
										<div class="input-group-append">
											<button type="submit" class="btn btn-lg btn-default">
												<i class="fa fa-search"></i>
											</button>
										</div>
									</div>
								</div>
							</div>
                        </div>
                        
                    </div>
                    <div class="col-md-10 offset-md-1" id="search_results_products"></div>
                    <?php
                    ?>
                    <!-- /.card-body -->
						
                </div>
                <div class="card-footer">
					<div class="card-tools text-right">
						<a href="<?php echo ROOT_URL;?>/admin/plugins/gevorest_stocktaking/stock_taking_stores" class="btn btn-default">Cancel</a>
					</div>
				</div>
            </form>
        </div>
    </section>
    
    
<script>

	function increase_qty(that){
		var qty = $(that).closest('div').find('.' + $(that).attr('data-field')).val()  - 0;
		var newqty = qty + 1;
		$(that).closest('div').find('.' + $(that).attr('data-field')).val(newqty);
	}
	function decrease_qty(that){
		var qty = $(that).closest('div').find('.' + $(that).attr('data-field')).val()  - 0;
		var newqty = qty - 1;
		$(that).closest('div').find('.' + $(that).attr('data-field')).val(newqty);
	}
	
	$('#search_form').on('reset', function(e){
		$('#filter_row').hide();
		$('#search_results_products').html('');
		$('#search_term').focus();
	});
		
	function select_product(productid){
		$('#search_by').val('id');
		$('#search_term').val(productid);
		$('#search_term').focus();
		return false;
	} 

	


	function return_product_results(pageid){
		$.ajax({
			url: "../../plugins/gevorest_stocktaking/interfaces/ajax/retrieve_scanned_products.php?pageid=" + pageid,
			type: "POST",
			data: $("#search_form input, #search_form select" ).serialize(),
			datatype: "text",

			success: function (result) {
				$('#search_results_products').html(result);
			},
			error: function (error) {
			  alert("DB Error");
			}       
		});
		
   	 }
   	 
   	 $( document ).ready(function() {
		return_product_results(1);
		$('#search_term').focus();
	});
</script>
