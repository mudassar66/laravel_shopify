<?php
/**
 * @author danil danil.kabluk@gmail.com
 */

namespace App\Providers;

use App\Services\shopify\Client;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class ShopifyServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton([Client::class, 'shopify'], function ($app) {
            /** @var Request $request */
            $request = $app['request'];
            $shop = $request->input('shop');

            return new Client($shop, null, env('SHOPIFY_KEY'), env('SHOPIFY_SECRET'));
        });
    }
}