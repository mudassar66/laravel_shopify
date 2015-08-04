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
                shopOrigin: 'https://<?= $_SESSION['domain'] ?>',
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
    <h2 class="content-head is-center">Pay what you want Configuration</h2>

    <div class="loading hide"></div>
    <div class="pure-g">
        <div class="l-box-lrg pure-u-1 pure-u-md-5-5">

            <h4>Congratulation! You have successfully installed Pay what you want app</h4>

            <p>Next Step</p>

            <p>
                We have did all required configuration automatically. Now you just have to create a product with tag
                "<b>PWYW</b>" or you can modify existing product and add tag "<b>PWYW</b>".
            </p>

            <p>
                Once you assign tag to product and still not show Pay what you want option on your product page kindly
                contact to our support <a href='mailto:<?= env('SUPPORT_EMAIL') ?>'><?= env('SUPPORT_EMAIL') ?></a>.
            </p>

        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="<?= url('/js/functions.js') ?>"></script>
</body>
</html>