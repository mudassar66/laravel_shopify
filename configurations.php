<?php
    require 'includes/config.php'; 
	require 'includes/shopify.php';
	
	$isEmbeddedPage	= 1;
	
	
	
	require 'includes/header.php'; 
?>	
<div class="content">
	<h2 class="content-head is-center">Pay what you want Configuration</h2>
	<div class="loading hide"></div>
	<div class="pure-g">
		<div class="l-box-lrg pure-u-1 pure-u-md-5-5">
		
		      <h4>Congratulation! You have successfully installed Pay what you want app</h4>
				
				<p> Next Step </p>
				
				<p> We have did all required configuration automatically. Now you just have to create a product with tag "<b>PWYW</b>" or you can modify existing product and add tag "<b>PWYW</b>".</p>
				
				<p> Once you assign tag to product and still not show Pay what you want option on your product page kindly contact to our support <a href='mailto:<?php echo SUPPORT_EMAIL; ?>'><?php echo SUPPORT_EMAIL; ?></a>. </p>
			
		</div>
		
	</div>
</div>
<?php require 'includes/footer.php';  ?>
