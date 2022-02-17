<meta charset="UTF-8">
<?php
			set_time_limit(0);
			ini_set("memory_limit","2048M");
			error_reporting(E_ALL);
			date_default_timezone_set('Europe/Nicosia');
			$today = date("Y-m-d H:i:s");
			
			include_once '../config/database.php';
    		include_once '../classes/all_classes.php';
    		
    		$database = new Database();
    		$db = $database->getConnection();
    		
    		
    		$item = new Synchronization($db);
			$item->tablename = 'esoftlevels';
			$item->itemsarray = (object)$response['invLevelList'];
			$response = json_decode($item->addMultipleRecordsEsoft());
				
				
    		// $item = new Synchronization($db);
//     		$item->tablename = 'esoftaccounts';
//     		$item->itemsarray = (object)$response['AccountsList'];
//     		$response = json_decode($item->SynchronizeEsoft());
//     		die;
    		
// 			DEM,MAR
			$company_name = 'MAR';
			$company_name = 'DEM';



			$url = 'http://212.31.106.134:1001/api/token';
			
			$fields = array(
				'username'      => 'gevorest',
				'password'       => 'f0#s3GV.',
				'grant_type'     => 'password'
			);

			//url-ify the data for the POST
			$fields_string = http_build_query($fields);

			//open connection
			$ch = curl_init();

			//set the url, number of POST vars, POST data
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

			//So that curl_exec returns the contents of the cURL; rather than echoing it
			curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 

			//execute post
			$result = curl_exec($ch);
			// echo '<pre>';
			// echo $result."<br>";
			// echo $result->error."<br>";
			// echo '</pre>';
			
			$xml =  json_decode($result);
			$access_token = $xml->access_token;
			curl_close($ch);
			
			// echo 'access_token: '.$access_token."<br>";
// 			die;
			if($access_token == ''){
				echo $access_token."<br>";
				die;
			}
			
			
			$curl = curl_init();				
				curl_setopt_array($curl, array(
				
				  CURLOPT_URL => "http://212.31.106.134:1001/api//items",
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => "",
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 0,
				  CURLOPT_FOLLOWLOCATION => true,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_CUSTOMREQUEST => "GET",
				  CURLOPT_POSTFIELDS =>"{\n\t\"Company\":\"".$company_name."\",\n\t\"LastSyncDate\":\"2018-01-18\"\n}",
				  CURLOPT_HTTPHEADER => array(
					"Content-Type: application/json",
					"Authorization: Bearer $access_token"
				  ),
				));

				$response = curl_exec($curl);
				$response =  json_decode($response, true);
				
				// echo '<pre>';
// 				print_r($response);
// 				echo '</pre>';
// 				
// 				die;
				// foreach($response['stkItemsList'] as $item){
// 					echo '<pre>';
// 					print_r($item);
// 					echo '</pre>';
// 					die;
// 				}
// 				$item = new Synchronization($db);
				$item->tablename = 'esoftproducts';
				$item->itemsarray = (object)$response['stkItemsList'];
				$response = json_decode($item->addMultipleRecordsEsoft());
				echo 'finished with items<br>';
				
				// Retrieve Levels
				$curl = curl_init();
				curl_setopt_array($curl, array(
				  CURLOPT_URL => "http://212.31.106.134:1001/api//levels",
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => "",
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 0,
				  CURLOPT_FOLLOWLOCATION => true,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_CUSTOMREQUEST => "GET",
				  CURLOPT_POSTFIELDS =>"{\n\t\"Company\":\"".$company_name."\"\n}",
				  CURLOPT_HTTPHEADER => array(
					"Content-Type: application/json",
					"Authorization: Bearer $access_token"
				  ),
				));

				$response = curl_exec($curl);

				curl_close($curl);
				$response =  json_decode($response, true);
				// echo '<pre>';
// 				print_r($response);
// 				echo '</pre>';
// 				
// 				die;
				
				$item = new Synchronization($db);
				$item->tablename = 'esoftlevels';
				$item->itemsarray = (object)$response['invLevelList'];
				$response = json_decode($item->addMultipleRecordsEsoft());
				echo 'finished with levels<br>';
				die;






			
			
				
				// die;
			
			/*
			$curl = curl_init();

				curl_setopt_array($curl, array(
				  CURLOPT_URL => "http://212.31.106.134:1001/api//AccAccounts",
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => "",
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 0,
				  CURLOPT_FOLLOWLOCATION => true,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_CUSTOMREQUEST => "GET",
				  CURLOPT_POSTFIELDS =>"{\r\n  \"Company\": \"".$company_name."\",\r\n  \"LastSyncDate\":\"2019-01-18\"\r\n}",
				  CURLOPT_HTTPHEADER => array(
					"Content-Type: application/json",
					"Authorization: Bearer $access_token"
				  ),
				));

				$response = curl_exec($curl);
				$response =  json_decode($response, true);
				$items_array = array();
				foreach($response['AccountsList'] as $key => $record){
					echo '<pre>';
					print_r($record);
					echo '</pre>';
					if($key == 5){
						break;
					}
				}
			
			*/	
				
				
				
				
				
				
				$curl = curl_init();				
				curl_setopt_array($curl, array(
				
				  CURLOPT_URL => "http://212.31.106.134:1001/api//Salesperson",
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => "",
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 0,
				  CURLOPT_FOLLOWLOCATION => true,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_CUSTOMREQUEST => "GET",
				  CURLOPT_POSTFIELDS =>"{\n\t\"Company\":\"".$company_name."\",\n\t\"LastSyncDate\":\"2018-01-18\"\n}",
				  CURLOPT_HTTPHEADER => array(
					"Content-Type: application/json",
					"Authorization: Bearer $access_token"
				  ),
				));

				$response = curl_exec($curl);
				$response =  json_decode($response, true);
				
				
				
				$item = new Synchronization($db);
				$item->tablename = 'esoftsalespersons';
				$item->itemsarray = (object)$response['Salespersons'];
				$response = json_decode($item->addMultipleRecordsEsoft());
				
				
				$curl = curl_init();				
				curl_setopt_array($curl, array(
				
				  CURLOPT_URL => "http://212.31.106.134:1001/api//Stores",
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => "",
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 0,
				  CURLOPT_FOLLOWLOCATION => true,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_CUSTOMREQUEST => "GET",
				  CURLOPT_POSTFIELDS =>"{\n\t\"Company\":\"".$company_name."\",\n\t\"LastSyncDate\":\"2018-01-18\"\n}",
				  CURLOPT_HTTPHEADER => array(
					"Content-Type: application/json",
					"Authorization: Bearer $access_token"
				  ),
				));

				$response = curl_exec($curl);
				$response =  json_decode($response, true);
				
				$item = new Synchronization($db);
				$item->tablename = 'esoftstores';
				$item->itemsarray = (object)$response['Stores'];
				$response = json_decode($item->addMultipleRecordsEsoft());
				
					
				$curl = curl_init();				
				curl_setopt_array($curl, array(
				
				  CURLOPT_URL => "http://212.31.106.134:1001/api//items",
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => "",
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 0,
				  CURLOPT_FOLLOWLOCATION => true,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_CUSTOMREQUEST => "GET",
				  CURLOPT_POSTFIELDS =>"{\n\t\"Company\":\"".$company_name."\",\n\t\"LastSyncDate\":\"2018-01-18\"\n}",
				  CURLOPT_HTTPHEADER => array(
					"Content-Type: application/json",
					"Authorization: Bearer $access_token"
				  ),
				));

				$response = curl_exec($curl);
				$response =  json_decode($response, true);
				
				// echo '<pre>';
// 				print_r($response);
// 				echo '</pre>';
// 				
// 				die;
				// foreach($response['stkItemsList'] as $item){
// 					echo '<pre>';
// 					print_r($item);
// 					echo '</pre>';
// 					die;
// 				}
// 				$item = new Synchronization($db);
				$item->tablename = 'esoftproducts';
				$item->itemsarray = (object)$response['stkItemsList'];
				$response = json_decode($item->addMultipleRecordsEsoft());
				
				// Retrieve Levels
				$curl = curl_init();
				curl_setopt_array($curl, array(
				  CURLOPT_URL => "http://212.31.106.134:1001/api//levels",
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => "",
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 0,
				  CURLOPT_FOLLOWLOCATION => true,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_CUSTOMREQUEST => "GET",
				  CURLOPT_POSTFIELDS =>"{\n\t\"Company\":\"".$company_name."\"\n}",
				  CURLOPT_HTTPHEADER => array(
					"Content-Type: application/json",
					"Authorization: Bearer $access_token"
				  ),
				));

				$response = curl_exec($curl);

				curl_close($curl);
				$response =  json_decode($response, true);
				
				$item = new Synchronization($db);
				$item->tablename = 'esoftlevels';
				$item->itemsarray = (object)$response['invLevelList'];
				$response = json_decode($item->addMultipleRecordsEsoft());
				
				$curl = curl_init();

			/*
			curl_setopt_array($curl, array(
			  CURLOPT_URL => "http://212.31.106.134:1001/api//StockAvailability",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "GET",
			  CURLOPT_POSTFIELDS =>"{\r\n  \"Company\": \"".$company_name."\"\r\n}",
			  CURLOPT_HTTPHEADER => array(
				"Content-Type: application/json",
				"Authorization: Bearer $access_token"
			  ),
			));

			$response = curl_exec($curl);
			$response =  json_decode($response, true);
			
			$item = new Synchronization($db);
			$item->tablename = 'esoftstockdistribution';
			$item->itemsarray = (object)$response['ItemAvailStockList'];
			$response = json_decode($item->addMultipleRecordsEsoft());
			*/	
				
				
			/*
			$curl = curl_init();

				curl_setopt_array($curl, array(
				  CURLOPT_URL => "http://212.31.106.134:1001/api//AccAccounts",
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => "",
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 0,
				  CURLOPT_FOLLOWLOCATION => true,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_CUSTOMREQUEST => "GET",
				  CURLOPT_POSTFIELDS =>"{\r\n  \"Company\": \"".$company_name."\",\r\n  \"LastSyncDate\":\"2019-01-18\"\r\n}",
				  CURLOPT_HTTPHEADER => array(
					"Content-Type: application/json",
					"Authorization: Bearer $access_token"
				  ),
				));

				$response = curl_exec($curl);
				$response =  json_decode($response, true);
				$items_array = array();
				foreach($response['AccountsList'] as $key => $record){
					$item_array = array();
					$item_array['Code'] = $record['Code'];
					$item_array['Name1'] = $record['Name1'];
					$item_array['Name2'] = $record['Name2'];
					$item_array['AccountType'] = $record['AccountType'];
					$item_array['AccountTypeName'] = $record['AccountTypeName'];
					$item_array['LedgerID'] = $record['LedgerID'];
					$item_array['AccountShort'] = $record['AccountShort'];
					$item_array['Currency'] = $record['Currency'];
					$item_array['DefaultVatCode'] = $record['DefaultVatCode'];
					$item_array['AccountGroupDisc'] = $record['AccountGroupDisc'];
					$item_array['AccountPriceList'] = $record['AccountPriceList'];
					$item_array['AccountPriceCode'] = $record['AccountPriceCode'];
					$item_array['AccountPaymentMethod'] = $record['AccountPaymentMethod'];
					$item_array['AccountSalesperson'] = $record['AccountSalesperson'];
					$item_array['Store'] = $record['Store'];
					$item_array['DellAddress1'] = $record['Address']['DellAddress1'];
					$item_array['DellAddress2'] = $record['Address']['DellAddress2'];
					$item_array['DelTown'] = $record['Address']['DelTown'];
					$item_array['DelCity'] = $record['Address']['DelCity'];
					$item_array['DelPostCode'] = $record['Address']['DelPostCode'];
					$item_array['DelCountry'] = $record['Address']['DelCountry'];
					$item_array['PostalAddress1'] = $record['Address']['PostalAddress1'];
					$item_array['PostalAddress2'] = $record['Address']['PostalAddress2'];
					$item_array['PostalTown'] = $record['Address']['PostalTown'];
					$item_array['PostalCity'] = $record['Address']['PostalCity'];
					$item_array['PostalPostCode'] = $record['Address']['PostalPostCode'];
					$item_array['PostalCountry'] = $record['Address']['PostalCountry'];
					$item_array['POBOX'] = $record['Address']['POBOX'];
					$item_array['POBOXPostCode'] = $record['Address']['POBOXPostCode'];
					$item_array['POBOXCity'] = $record['Address']['POBOXCity'];
					$item_array['WorkPhone'] = $record['Address']['WorkPhone'];
					$item_array['HomePhone'] = $record['Address']['HomePhone'];
					$item_array['MobilePhone'] = $record['Address']['MobilePhone'];
					$item_array['Fax'] = $record['Address']['Fax'];
					$item_array['Email'] = $record['Address']['Email'];
					$items_array[] = $item_array;
				}
				$item = new Synchronization($db);
				$item->tablename = 'esoftaccounts';
				
				$item->itemsarray = (object)$items_array;
				$response = json_decode($item->addMultipleRecordsEsoft());
				*/
				
				
				echo "<br>Synchronization finished<br>";
?>