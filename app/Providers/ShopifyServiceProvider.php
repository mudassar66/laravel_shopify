<?php
/**
 * @author danil danil.kabluk@gmail.com
 */

namespace App\Providers;

use app\Services\shopify\Client;
use Illuminate\Support\ServiceProvider;

class ShopifyServiceProvider extends ServiceProvider
{
    public function register()
    {
        $client = new Client($_REQUEST['shop'], null, env('SHOPIFY_KEY'), env('SHOPIFY_SECRET'));
        $this->app->instance('shopify', $client);
    }
}