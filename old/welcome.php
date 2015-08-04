<?php
    require 'includes/config.php';
	require 'includes/shopify.php';


	require 'includes/header.php';
?>


 <div class="content">
	<h2 class="content-head is-center">Signup & Signin to Your Account</h2>
	<div class="loading hide"></div>
	<div class="pure-g">
		<div class="l-box-lrg pure-u-1 pure-u-md-2-5">

		    <div id="messageBox">
			</div>
			<form class="pure-form pure-form-stacked" method="post">
				<fieldset>
					<label for="addToCartSelector">Shop URL</label>
					<input Class="form-control" data-val="true" data-val-required="The Shop name field is required." id="shop" name="shop" placeholder="yourstore.myshopify.com" type="text" value="" />
					<p style="text-align:center;"><sup style="color:#F00;">*</sup> Enter Your Store's domain, Subdomain Version of myshopify.com <br>(<strong>xxx.MyShopify.com</strong> Version <strong>not</strong> the<strong> Naked Domain</strong>).</p>
					<div style="height:20px;"> &nbsp;</div>
					<button type="submit" class="pure-button">Submit</button>
				</fieldset>
			</form>
		</div>

		<div class="l-box-lrg pure-u-1 pure-u-md-3-5">
                <h4>Support Information</h4>
				<p>For any query or help write us to <br><a href='mailto:<?php echo SUPPORT_EMAIL; ?>'><?php echo SUPPORT_EMAIL; ?></a></p>

		</div>

	</div>
</div>

<?php require 'includes/footer.php';  ?>