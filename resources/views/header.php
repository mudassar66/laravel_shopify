<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
    <meta charset="utf-8"/>
    <title>Pay what you want for Shopify</title>

    <link href="<?php echo ASSETS_PATH; ?>img/favicon.png" rel="shortcut icon" type="image/x-icon"/>

    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>


    <script src="<?php echo JS_PATH; ?>functions.js"></script>

    <!-- Load javascripts at bottom, this will reduce page load time -->
    <!-- BEGIN CORE PLUGINS(REQUIRED FOR ALL PAGES) -->
    <!--[if lt IE 9]>
    <script src="<?php echo ASSETS_PATH; ?>plugins/respond.min.js"></script>
    <![endif]-->


    <link rel="stylesheet" href="<?php echo CSS_PATH; ?>embed/common/pure-min.css">
    <!--[if lte IE 8]>
    <link rel="stylesheet" href="<?php echo CSS_PATH; ?>embed/common/grids-responsive-old-ie-min.css">
    <![endif]-->
    <!--[if gt IE 8]><!-->
    <link rel="stylesheet" href="<?php echo CSS_PATH; ?>embed/common/grids-responsive-min.css">
    <!--<![endif]-->

    <!--[if lte IE 8]>
    <link rel="stylesheet" href="<?php echo CSS_PATH; ?>embed/layouts/marketing-old-ie.css">
    <![endif]-->
    <!--[if gt IE 8]><!-->
    <link rel="stylesheet" href="<?php echo CSS_PATH; ?>embed/layouts/marketing.css">
    <!--<![endif]-->

    <?php if ($isEmbeddedPage == 1) { ?>

        <script src="https://cdn.shopify.com/s/assets/external/app.js"></script>
        <script type="text/javascript">
            ShopifyApp.init({
                apiKey: '<?php echo SHOPIFY_API_KEY; ?>',
                shopOrigin: 'https://<?php echo $_SESSION['shop_domain']; ?>',
                debug: true
            });

            ShopifyApp.ready(function () {
                ShopifyApp.Bar.initialize({
                    icon: '<?php echo BASE_PATH; ?>images/app-icon.png',
                    title: 'PWYW Configuration',
                    buttons: {}
                });
            });

        </script>

    <?php } ?>

    <script src="<?php echo ASSETS_PATH; ?>plugins/jquery-1.10.2.min.js" type="text/javascript"></script>

    <!-- END CORE PLUGINS -->
</head>
<body>