<?php header('Access-Control-Allow-Origin: *');
	require 'shopify.php';
	
	define("SHOM_DOMAIN","indiedevkit.myshopify.com");
	
	define("SHOPIFY_TOKEN","fabc1b767a9aa12a2c909abf732c2e64");
	
	$action = $_GET['action'];

	switch($action)
	{
		case "createCart":
			$myfile = fopen("cartCreate.txt", "w") or die("Unable to open file!");
			$content = "";
			
			foreach($_REQUEST as $key => $val)
				$content .= $key. " = >".$val."\n";
				
			fwrite($myfile,$content);
			fclose($myfile);
			
			break;
			
		case "updateCart":
			$myfile = fopen("cartUpdate.txt", "w") or die("Unable to open file!");
			$content = "";
			foreach($_REQUEST as $key => $val)
				$content .= $key. " = >".$val."\n";
			fwrite($content, $txt);
			fclose($myfile);
			break;
			
		case "createProduct":
		
			$postArray = array();
			
			if($_REQUEST['productPrice']=="")
				$_REQUEST['productPrice'] = 0;
				
			$postArray['product'] = array(
										"title"=> $_REQUEST['productName'],
										"body_html"=> " ",
										"vendor"=> "Custom",
										"product_type"=> "Custom",
										"variants"=> array(array(
														"price" => $_REQUEST['productPrice'],
														"requires_shipping"=> false,
														"taxable"=> false
													)),
										"published" => false,
										"images"=> array( array( "src" => "https:".$_REQUEST['productImage']))
								);
			
			$sc = new ShopifyClient(SHOM_DOMAIN,SHOPIFY_TOKEN,SHOPIFY_API_KEY,SHOPIFY_SECRET);
			$productDetail = $sc->call('POST', '/admin/products.json', $postArray);
			
			echo $productDetail['variants'][0]['id'];
			break;
	}
?>