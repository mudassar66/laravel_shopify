<?php
namespace App\Services\shopify;

class ShopifyApiException extends \Exception
{
    protected $method;
    protected $path;
    protected $params;
    protected $response_headers;
    protected $response;

    /**
     * @param string $method
     * @param int $path
     * @param array $params
     * @param $response_headers
     * @param $response
     */
    function __construct($method, $path, $params, $response_headers, $response)
    {
        $this->method = $method;
        $this->path = $path;
        $this->params = $params;
        $this->response_headers = $response_headers;
        $this->response = $response;

        parent::__construct($response_headers['http_status_message'], $response_headers['http_status_code']);
    }

    function getMethod()
    {
        return $this->method;
    }

    function getPath()
    {
        return $this->path;
    }

    function getParams()
    {
        return $this->params;
    }

    function getResponseHeaders()
    {
        return $this->response_headers;
    }

    function getResponse()
    {
        return $this->response;
    }
}