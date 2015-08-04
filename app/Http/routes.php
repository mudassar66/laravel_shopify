<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', 'Controller@welcome');
$app->post('/', 'Controller@welcome');

$app->get('/config', 'Controller@config');

$app->get('/api', function (\Illuminate\Http\Request $request, \App\Services\shopify\Client $client) {
    $action = $request->get('action');

    switch ($action) {
        case 'createProduct':
            $row = DB::table('shops')
                ->select(['id', 'shop_token', 'shop_domain'])
                ->where('shop_secret', $request->get('token'))
                ->first();

            if ($row) {
                $postArray = [
                    'product' => [
                        'title' => $request->input('productNamePWYW'),
                        'body_html' => ' ',
                        'vendor' => 'Custom',
                        'product_type' => 'Custom',
                        'variants' => [
                            [
                                'price' => $request->input('productPricePWYW'),
                                'requires_shipping' => false,
                                'taxable' => false
                            ],
                        ],
                        'published' => false,
                        'images' => [['src' => 'https:' . $request->input('productImagePWYW')]],
                    ]
                ];

                $client->shop_domain = $row->shop_domain;
                $client->setToken($row->shop_token);
                $productDetail = $client->call('POST', '/admin/products.json', $postArray);

                echo $productDetail['variants'][0]['id'];

                return (new \Illuminate\Http\Response($productDetail['variants'][0]['id']))
                    ->header('Access-Control-Allow-Origin', '*');
            }
            break;
    }

    return abort(\Illuminate\Http\Response::HTTP_BAD_REQUEST);
});