<?php
	session_start();
	if($_SESSION['login']['status'] == true){
		include_once '../../../../config/database.php';
		$database = new Database();
    	$db = $database->getConnection();
		include_once '../../../../cloudcms/include/classes/all_classes.php';
// 		include_once '../../../../plugins/gevorest_pos/include/classes/plugin_classes.php';
		include_once '../../include/classes/plugin_classes.php';
    
    	
    	
    	$items = new ProductStockTaking($db);
    	$items->records_per_page = $_POST['records_number'];
    	$items->search_fields->category = $_POST['category'];
    	$items->page = 1;
    	$items->search_fields->customdimensions = 0;
    	$width = '0';
    	$length = '0';
    	
    	$_POST['search_term'] = str_replace(" ", "%", $_POST['search_term']);
    	if($_POST['search_term'] != ''){
    		$_POST['search_term'] = '%' . $_POST['search_term'] . '%';
    	}
    	
    	switch($_POST['search_by']){
			case 'barcode':
				$items->search_fields->barcode = $_POST['search_term'];
				break;
			case 'ext_code':
				$items->search_fields->ext_code = $_POST['search_term'];
				break;
			case 'id':
				$items->search_fields->id = $_POST['search_term'];
				break;
			case 'name':
				$items->search_fields->name = $_POST['search_term'];
				break;
			case 'category':
				$items->search_fields->category = $_POST['search_term'];
				break;
			case 'subcategory':
				$items->search_fields->subcategory = $_POST['search_term'];
				break;
			case 'brand':
				$items->search_fields->brand = $_POST['search_term'];
				break;
			case 'collection':
				$items->search_fields->collection = $_POST['search_term'];
				break;
		}
    	
    	switch($_POST['search_type']){
    		case 'filter':
    			$items->search_fields->dimensions = $_POST['filter_dimensions'];
    			if($_POST['filter_dimensions'] == 'UDE'){
    				$width = $_POST['width'];
    				$length = $_POST['length'];
    				$items->search_fields->customdimensions = 1;
    			}
//     			echo 'we are here<br>';
    			$items->search_fields->subcategory = $_POST['filter_sub_category'];
				$items->search_fields->collection = $_POST['filter_collection'];
				$items->search_fields->color = $_POST['filter_color'];
				$items->search_fields->model = $_POST['filter_model'];
				$items->search_fields->softness = $_POST['filter_softness'];
				$items->search_fields->length = $_POST['length'];
				$items->search_fields->width = $_POST['width'];
    			break;
    	}
    	// echo '<pre>';
//     	print_r($items->search_fields);
//     	echo '</pre>';
    	$items->page = $_GET['pageid'];
    	$items->order_by = $_POST['order_by'];
    	$response_products = json_decode($items->getProduct());
    	// echo '<pre>';
// 		print_r($response_products);
// 		echo '</pre>';
		
		
    	$response = array();
    	if($response_products->itemCount == 1){
    		$response_product = $response_products->records[0];
    		$qty_onhand = 0;
    		foreach($response_product->itemsdistribution as $itemsdistribution){
				if($itemsdistribution->store_id == $_POST['store_id']){
					$qty_onhand = $itemsdistribution->qty;
					break;
				}
    		}
    		$add_items = new ProductStockTaking($db);
    		$add_items->product_id = $response_product->id;
    		$add_items->store_id = $_POST['store_id'];
    		$add_items->qty_onhand = $qty_onhand;
    		$add_items->qty_found = $_POST['quantity'];
    		$add_items->cre_id = $_SESSION['login']['id'];
    		$add_items->upd_id = $_SESSION['login']['id'];
    		$response_add_stock_transaction = json_decode($add_items->addStockTransactionRelation());
    		echo json_encode($response_add_stock_transaction);
    	}
    	else{
			$html_content = '<div class="text-center form-group"><b>Number of Records:</b> '.$response_products->itemCount.'</div>';
		
			if(count($response_products->records) > 0){
			
				$html_content .= '<div class="card">
						<div class="card-body p-0">
							<div class="table-responsive">
								<table class="table table-striped">
									<thead>
										<tr>
											<th style="width: 90px">Code</th>
											<th style="width: 90px">Barcode</th>
											<th>Product Name</th>
											<th>Price</th>
											<th>Height</th>
											<th style="width: 90px">Actions</th>
										</tr>
									</thead>
									<tbody>';
										foreach($response_products->records as $product){
											$price = $product->price;
											$selling_price = $product->price;
											// if($product->offerprice > 0 AND $product->offerprice < $product->price){
	// 											$selling_price = $product->offerprice;
	// 										}
											$custom_dimensions = '';
											$custom_price = '';
											if($product->customdimensions == true){
												$custom_dimensions = '<span class="badge badge-success">Custom</span>';
												$price = $product->customprice;
												$selling_price = '';
												$price = $_POST['width'] * $_POST['length'] * $product->customprice / 10000;
											}
											$html_content .= '<tr>
																<td>'.$product->ext_code.'</td>
																<td>'.$product->barcode.'</td>
																<td>'.$product->name.'</td>
																<td>'.number_format($price, 2).'</td>
																<td>'.$product->height.'</td>
																<td><button class="btn btn-primary" onclick="select_product('.$product->id.');">Select</button></td>
															</td>';
										}
								
									$html_content .=  '</tbody>
								</table>
							</div>
						</div>
					</div>';
			}
			else{
				$html_content .=  '<div class="alert alert-warning form-group" role="alert">No product found</div>';
			}
			$html_content .=  '<div class="text-center form-group"><b>Go to Page</b> ';
				$html_content .=  '<select onchange="return_product_results(this.value);">';
					for($i = 1; $i <= $response_products->pageCount; $i++){
						$is_selected = '';
						if($_GET['pageid'] == $i){
							$is_selected = 'selected';
						}
						$html_content .=  '<option '.$is_selected.'>' . $i . '</option>';
					}
				
				$html_content .=  '</select>';
			$html_content .=  '</div>';
			
			$response_array = array();
			$response_array['success'] = 0;
			$response_array['message'] = $html_content;
			echo json_encode($response_array);
    	}
    	
    	
	}
?>