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

    <link href="<?= url('/img/favicon.png') ?>" rel="shortcut icon" type="image/x-icon"/>

    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>

    <!-- Load javascripts at bottom, this will reduce page load time -->

    <!-- BEGIN CORE PLUGINS(REQUIRED FOR ALL PAGES) -->
    <!--[if lt IE 9]>
    <script src="<?= url('/plugins/respond.min.js') ?>"></script>
    <![endif]-->

    <link rel="stylesheet" href="<?= url('/css/embed/common/pure-min.css') ?>">
    <!--[if lte IE 8]>
    <link rel="stylesheet" href="<?= url('/css/embed/common/grids-responsive-old-ie-min.css')?>">
    <![endif]-->
    <!--[if gt IE 8]><!-->
    <link rel="stylesheet" href="<?= url('/css/embed/common/grids-responsive-min.css') ?>">
    <!--<![endif]-->

    <!--[if lte IE 8]>
    <link rel="stylesheet" href="<?= url('/css/embed/layouts/marketing-old-ie.css')?>">
    <![endif]-->
    <!--[if gt IE 8]><!-->
    <link rel="stylesheet" href="<?= url('/css/embed/layouts/marketing.css') ?>">
    <!--<![endif]-->

    <?php if (isset($isEmbeddedPage) && $isEmbeddedPage): ?>
        <script src="https://cdn.shopify.com/s/assets/external/app.js"></script>
        <script type="text/javascript">
            ShopifyApp.init({
                apiKey: '<?= env('SHOPIFY_KEY') ?>',
                shopOrigin: 'https://<?= $_SESSION['shop_domain'] ?>',
                debug: <?= App::environment('production') ? 'false' : 'true' ?>
            });

            ShopifyApp.ready(function () {
                ShopifyApp.Bar.initialize({
                    icon: '<?= env('BASE_PATH') ?>images/app-icon.png',
                    title: 'PWYW Configuration',
                    buttons: {}
                });
            });

        </script>
    <?php endif ?>
    <!-- END CORE PLUGINS -->
</head>
<body>

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
                    <input Class="form-control" data-val="true" data-val-required="The Shop name field is required."
                           id="shop" name="shop" placeholder="yourstore.myshopify.com" type="text" value=""/>

                    <p style="text-align:center;">
                        <sup style="color:#F00;">*</sup> Enter Your Store's domain, Subdomain Version of myshopify.com
                        <br>
                        (<strong>xxx.MyShopify.com</strong> Version <strong>not</strong> the<strong> Naked
                            Domain</strong>).
                    </p>

                    <div style="height:20px;"> &nbsp;</div>
                    <button type="submit" class="pure-button">Submit</button>
                </fieldset>
            </form>
        </div>

        <div class="l-box-lrg pure-u-1 pure-u-md-3-5">
            <h4>Support Information</h4>

            <p>
                For any query or help write us to <br>
                <a href='mailto:<?= env('SUPPORT_EMAIL') ?>'><?= env('SUPPORT_EMAIL') ?></a>
            </p>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="<?= url('/js/functions.js') ?>"></script>
</body>
</html>