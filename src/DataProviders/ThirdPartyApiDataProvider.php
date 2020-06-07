<?php

declare(strict_types=1);

namespace DenverSera\CommissionTask\DataProviders;

use DenverSera\CommissionTask\ErrorHandlers\EmptyDataErrorException;
use DenverSera\CommissionTask\ErrorHandlers\InvalidUrlErrorException;
use DenverSera\CommissionTask\Interfaces\DataProviderInterface;
use DenverSera\CommissionTask\Services\Http\HttpRequestService;
use DenverSera\CommissionTask\Services\Http\HttpResponseOutputterService;

class ThirdPartyApiDataProvider implements DataProviderInterface
{
    /**
     * The HTTP Request Service object
     *
     * @var HttpRequestService
     */
    private $httpRequestService;

    /**
     * The HTTP Response Outputter Service object
     *
     * @var HttpResponseOutputterService
     */
    private $httpResponseOutputterService;

    /**
     * The third party API URL
     *
     * @var string
     */
    private $apiUrl;

    /**
     * The raw api response
     *
     * @var string
     */
    private $apiResponse;

    /**
     * Class constructor
     *
     * @param HttpRequestService $httpRequestService
     */
    public function __construct(HttpRequestService $httpRequestService, HttpResponseOutputterService $httpResponseOutputterService)
    {
        $this->httpRequestService = $httpRequestService;
        $this->httpResponseOutputterService = $httpResponseOutputterService;
    }

    /**
     * Fetches data from an external data source such as API endpoint
     *
     * @return self
     */
    public function fetchData() : self
    {
        $url = $this->getApiUrl();
   
        if ($url === '' || empty($url)) {
            throw new InvalidUrlErrorException("Request URL is empty. API URL must be set first.", 'ThirdPartyApiDataProvider@fetchData');
        }

        $response = $this->httpRequestService->get($this->getApiUrl());

        if ($response === false || empty($response)) {
            throw new EmptyDataErrorException("Response empty. No data has been returned from ". $this->getApiUrl(), 'ThirdPartyApiDataProvider@fetchData');
        }

        $this->setApiResponse($response);

        return $this;
    }

    /**
     * Outputs the given API response to object
     *
     * @return object
     */
    public function outputDataToObject() : object
    {
        $apiResponse = $this->getApiResponse();

        return $this->httpResponseOutputterService->outputResponseToObject($apiResponse);
    }

    /**
     * Gets the API URL
     *
     * @return string
     */
    public function getApiUrl() : string
    {
        return $this->apiUrl;
    }

    /**
     * Gets the raw API response
     *
     * @return void
     */
    private function getApiResponse()
    {
        return $this->apiResponse;
    }

    /**
     * Sets the API URL
     *
     * @param string $apiUrl
     * @return self
     */
    public function setApiUrl(string $apiUrl) : self
    {
        $this->apiUrl = $apiUrl;

        return $this;
    }

    /**
     * Sets the API response
     *
     * @param string $apiResponse
     * @return self
     */
    private function setApiResponse(string $apiResponse) : self
    {
        $this->apiResponse = $apiResponse;

        return $this;
    }
}
