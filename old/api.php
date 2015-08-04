<?php header('Access-Control-Allow-Origin: *');
	
	require 'includes/config.php'; 
	require 'includes/shopify.php';
	
	$action = $_GET['action'];

	switch($action)
	{
		case "createProduct":
			
		$qry = "SELECT id,shop_token,shop_domain FROM shops WHERE shop_secret = '".$_GET['token']."'";
		$query = mysql_query($qry, $link);
		
		if(mysql_num_rows($query) > 0)
		{
			$shopResult = mysql_fetch_array($query);
			$postArray = array();
			
			if($_REQUEST['productPrice']=="")
				$_REQUEST['productPrice'] = 0;
				
			$postArray['product'] = array(
										"title"=> $_REQUEST['productNamePWYW'],
										"body_html"=> " ",
										"vendor"=> "Custom",
										"product_type"=> "Custom",
										"variants"=> array(array(
														"price" => $_REQUEST['productPricePWYW'],
														"requires_shipping"=> false,
														"taxable"=> false
													)),
										"published" => false,
										"images"=> array( array( "src" => "https:".$_REQUEST['productImagePWYW']))
								);
			
			$sc = new ShopifyClient($shopResult['shop_domain'],$shopResult['shop_token'],SHOPIFY_API_KEY,SHOPIFY_SECRET);
			$productDetail = $sc->call('POST', '/admin/products.json', $postArray);
			
			echo $productDetail['variants'][0]['id'];
		}
			break;
	}
?>
