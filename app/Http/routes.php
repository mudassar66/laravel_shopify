<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
$app->get('/', 'Controller');

$app->get('/', function (\Illuminate\Http\Request $request, \App\Services\shopify\Client $client) {

//$app->get('/', function() use ($app) {
//    return $app->welcome();
//});
   
//   
//    $postArray = [
//                'variant' => [
//                    'title' => "test",
//                    'body_html' => ' ',
//                    'vendor' => 'Custom',
//                    'product_type' => 'Custom',
//                    'variants' => [
//                        [
//                            'price' => "ssaas",
//                            'requires_shipping' => false,
//                            'taxable' => false
//                        ],
//                    ],
//                    'published' => false,
//                    'images' => [['src' => 'https:' . 'aas']],
//                ]
//            ];
            $postArray = [
                'variant' => [
                     
                            'option1' => "new title",
                            'price' => "10.00" 
                       
                    ]
            ];
            //$client->shop_domain = env('SHOPIFY_SHOP');
             //$baseurl = "https://{$this->shop_domain}/";

            $pid = 1370603653;
            // $productDetail = $client->call('POST', '/admin/products.json', $postArray);
            $productDetail = $client->call('POST', '/admin/products/'.$pid.'/variants.json', $postArray);

            echo $productDetail['variants'][0]['id'];

            return $app->welcome();
       
  
  
  });