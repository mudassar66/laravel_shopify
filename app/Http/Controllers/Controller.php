<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * Client instance, that used for accessing shopify
     * @var \app\Services\shopify\Client
     */
    protected $client;

    protected $request;

    public function __construct(\App\Services\shopify\Client $client, Request $request)
    {
        $this->client = $client;
        $this->request = $request;
    }

    public function welcome()
    {
        $shop = $this->request->input('shop');

        if ($shop) {
            // shop is already loaded
            if (session('loaded_shop') === $shop) {
                return redirect('config');
            }

            // there is no loaded shop, or loaded another shop
            // then try to find in the DB
            $row = DB::table('shops')
                ->select(['id', 'shop_token', 'shop_name', 'shop_secret', 'shop_url'])
                ->where('shop_url', $shop)
                ->orWhere('shop_domain', $shop)
                ->first();

            // no row found and we got code for API - save new shop
            $code = $this->request->input('code');
            if (!$row && $code) {
                list($activeThemeId, $activeThemeMobileId) = $this->getShopActiveThemes();

                $row = $this->saveShop($code, $activeThemeId, $activeThemeMobileId);

                // put shopify snippet to the main theme
                if ($this->addSnippet($activeThemeId, $row->shop_secret)) {
                    $this->makeSnippetIncluded($activeThemeId);
                }
            }

            if ($row) {
                // save to session and redirect to the config page
                $this->fillSession($shop, $row);

                return redirect('config');
            }

            // form is sent from the page
            if (isset($_GET['hmac']) || $this->request->isMethod('post')) {
                $currentUrl = str_replace('http:', 'https:', $this->request->fullUrl());

                // redirect to the auth form
                return redirect($this->client->getAuthorizeUrl(env('SHOPIFY_SCOPE'), $currentUrl));
            }
        }

        return view('welcome');
    }

    public function config()
    {
        return view('config');
    }

    /**
     * @return array of two ids - shop's main and mobile themes
     * @throws \App\Services\shopify\ShopifyApiException
     */
    protected function getShopActiveThemes()
    {
        $themes = $this->client->call('GET', '/admin/themes.json', ['published_status' => 'published']);
        $activeThemeId = $activeThemeMobileId = null;

        foreach ($themes as $theme) {
            if ($theme['role'] == 'main') {
                $activeThemeId = $theme['id'];
            }
            if ($theme['role'] == 'mobile') {
                $activeThemeMobileId = $theme['id'];
            }
        }

        if (!$activeThemeMobileId) {
            $activeThemeMobileId = $activeThemeId;
        }

        return [$activeThemeId, $activeThemeMobileId];
    }

    /**
     * Adds new snippet rendered from the view 'shopifySnippet'
     * @param $activeThemeId
     * @param string $secret shop's secret
     * @return array|mixed
     * @throws \App\Services\shopify\ShopifyApiException
     */
    protected function addSnippet($activeThemeId, $secret)
    {
        $postArray = [
            'assets' => [
                'key' => 'snippets/pwyw.liquid',
                'value' => view('shopifySnippet', ['secret' => $secret])->render(),
            ],
        ];

        return $this->client->call('PUT', "/admin/themes/{$activeThemeId}/assets.json", $postArray);
    }

    /**
     * Ensures that added snippet is included, otherwise adds include block
     * @param $activeThemeId
     * @return array|bool|mixed
     * @throws \App\Services\shopify\ShopifyApiException
     */
    protected function makeSnippetIncluded($activeThemeId)
    {
        $result = $this->client->call('GET',
            "/admin/themes/{$activeThemeId}/assets.json?asset[key]=templates/product.liquid&theme_id={$activeThemeId}");

        if (false === strpos($result['value'], "{% include 'pwyw' %}")) {
            $postArray = [
                'assets' => [
                    'key' => 'templates/product.liquid',
                    'value' => $result['value'] . "{% include 'pwyw' %}",
                ],
            ];

            return $this->client->call('PUT', "/admin/themes/{$activeThemeId}/assets.json", $postArray);
        }

        // already included
        return true;
    }

    /**
     * Saves new shop and returns inserted row attributes
     * @param $code
     * @param $theme
     * @param $mobileTheme
     * @return object
     * @throws \App\Services\shopify\ShopifyApiException
     */
    protected function saveShop($code, $theme, $mobileTheme)
    {
        // create new shop
        $token = $this->client->getAccessToken($code);

        $this->client->setToken($token);
        $shop = $this->client->call('GET', '/admin/shop.json', ['published_status' => 'published']);

        // save new shop
        $shopSecret = md5(uniqid(rand(), true));
        $attributes = [
            'shop_owner' => $shop->shop_owner,
            'shop_name' => $shop->name,
            'shop_token' => $token,
            'shop_url' => $shop->domain,
            'shop_domain' => $shop->myshopify_domain,
            'shop_country' => $shop->country_code,
            'shop_email' => $shop->email,
            'shop_plan' => $shop->plan_name,
            'shop_currency' => $shop->currency,
            'shop_secret' => $shopSecret,
            'province_code' => $shop->province_code,
            'city' => $shop->city,
            'address1' => $shop->address1,
            'active_theme_id' => $theme,
            'active_theme_mobile_id' => $mobileTheme,
            'join_datetime' => date('Y-m-d H:i:s'),
        ];
        $id = DB::table('shops')->insertGetId($attributes);
        $attributes['id'] = $id;

        // simulate return like it's a found row from DB - stdclass
        return (object)$attributes;
    }

    /**
     * @param string $key that used for request (shop name or domain)
     * @param \stdClass $row attributes of the saved shop
     * @return mixed
     */
    protected function fillSession($key, $row)
    {
        return session([
            'token' => $row->shop_token,
            'shop_domain' => $row->shop_url,
            'shop_name' => $row->shop_name,
            'shop_secret' => $row->shop_secret,
            'shop_id' => $row->id,
            'loaded_shop' => $key,
        ]);
    }
}
