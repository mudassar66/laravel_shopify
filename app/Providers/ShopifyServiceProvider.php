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
    /**
     * @var Request
     */
    protected $request;

    public function __construct(Request $request, $app)
    {
        parent::__construct($app);

        $this->request = $request;
    }

    public function register()
    {
        $shop = $this->request->input('shop');
        $client = new Client($shop, null, env('SHOPIFY_KEY'), env('SHOPIFY_SECRET'));
        $this->app->instance('shopify', $client);
    }
}