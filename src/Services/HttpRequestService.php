<?php

declare(strict_types=1);

namespace DenverSera\CommissionTask\Services;

/**
 * HttpRequestService
 */
class HttpRequestService
{
    /**
     * HTTP Request using GET method through file_get_contents
     *
     * @param string $url
     * @return void
     */
    public function get(string $url)
    {
        // Create a stream
        $opts = [
            'http' => [
                'method' => "GET",
                'header' => "Accept-language: en\r"
            ]
        ];
        
        $context = stream_context_create($opts);

        return file_get_contents($url, false, $context);
    }
}
