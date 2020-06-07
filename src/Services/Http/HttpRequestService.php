<?php

declare(strict_types=1);

namespace DenverSera\CommissionTask\Services\Http;

use DenverSera\CommissionTask\ErrorHandlers\HttpRequestErrorException;
use Exception;

/**
 * HttpRequestService
 */
class HttpRequestService
{
    /**
     * HTTP Request using GET method through file_get_contents
     *
     * @param string $url
     * @return mixed
     */
    public function get(string $url, array $params = [])
    {
        try {
            // Create a stream
            $opts = [
                'http' => [
                    'method' => "GET",
                    'header' => "Accept-language: en\r"
                ]
            ];
            
            $context = stream_context_create($opts);

            // formulate query string for parameters
            $params = http_build_query($params);

            return file_get_contents($url . $params, false, $context);
        } catch (Exception $e) {
            throw new HttpRequestErrorException($e->getMessage(), 'HTTPRequestService@get');
        }
    }
}
