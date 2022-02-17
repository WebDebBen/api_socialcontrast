<?php
	
	if(isset($_GET['action']) && $_GET['action'] == 'delete'){
		$item = new ProductStockTaking($db);
		$item->store_id = $_GET['id'];
		$response = $item->deleteStockTakingProducts();
		$redirect_link = 'https://'.$_SERVER['HTTP_HOST'].'/admin/plugins/gevorest_stocktaking/stock_taking_scan/'.$_GET['id'];
		echo '<script type="text/javascript">window.location = "'.$redirect_link.'";</script>';
	}
?>
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<!-- /.card-header -->
					<div class="card-body table-responsive p-0">
						<table class="table table-hover text-nowrap salesman_table">
							<thead>
								<tr>
									<th>ID</th>
									<th>Ext Code</th>
									<th>Name</th>
									<th>Products</th>
									<th class="text-right">Action</th>
								</tr>
							</thead>
							<tbody>
							<?php
								$items = new Store($db);
								$items->records_per_page = 1000;
								$items->page = 1;
								$response = json_decode($items->getStore());
								foreach($response->records as $store){
									$items_scanned = new ProductStockTaking($db);
									$items_scanned->search_fields->store_id = $store->id;
    								$response_scanned_products = json_decode($items_scanned->getScannedProducts());
    								$number_of_scanned_products = $response_scanned_products->itemCount;
									echo '<tr>
												<input type="hidden" name="id[]" value="'.$store->id.'">
												<td>'.$store->id.'</td>
												<td>
													'.$store->ext_code.'
												</td>
												<td>
													'.$store->name.'
												</td>
												<td>
													<a href="https://'.$_SERVER['HTTP_HOST'].'/admin/plugins/gevorest_stocktaking/stock_taking_products/'.$store->id.'" class="btn btn-success">Products ('.$number_of_scanned_products.')</a>
												</td>
												<td class="text-right">
													<a href="javascript:delete_stocktakingdate('.$store->id.',\''.$store->name.'\')" class="btn btn-danger">New Stock Taking</a> 
													<a href="https://'.$_SERVER['HTTP_HOST'].'/admin/plugins/gevorest_stocktaking/stock_taking_scan/'.$store->id.'" class="btn btn-primary">Continue Scan</a>
												</td>
										</tr>';
								}
							?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script>
	function delete_stocktakingdate(storeid, storename){
		var input_text = prompt("New Stock Taking will result resetting (deleting) all stock taking of products of this selected store ("+storename+"). If you still wish to proceed with the New Stock Taking, type 'PROCEED'.", "");
		if(input_text === 'PROCEED'){
			var redirect_link = "https://<?php echo $_SERVER['HTTP_HOST']?>/admin/plugins/gevorest_stocktaking/stock_taking_stores/delete/"+storeid;
		
			window.location = redirect_link;
		}
	}
</script>
