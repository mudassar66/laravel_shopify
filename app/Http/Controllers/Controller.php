<?php namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected $client;

    protected $request;

    public function __construct(\App\Services\shopify\Client $client, Request $request)
    {
        $this->client = $client;
        $this->request = $request;
    }
}
