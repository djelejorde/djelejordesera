<?php

declare(strict_types=1);

namespace DenverSera\CommissionTask\DataProviders;

use DenverSera\CommissionTask\Entities\CurrencyExchange;
use DenverSera\CommissionTask\Interfaces\DataProviderInterface;
use DenverSera\CommissionTask\Services\HttpRequestService;

/**
 * EuCurrencyExchangeDataProvider Class
 *
 * Provides exhanges rates through an external API which is published by the European Central Bank
 *
 * Data source would be coming from https://api.exchangeratesapi.io/latest
 * More info on: https://exchangeratesapi.io/
 *
 * List of abbreviations that is used within this class:
 *
 * API - Application Programming Interface
 * URL - Uniform Resource Location
 *
 */
class EuCurrencyExchangeDataProvider implements DataProviderInterface
{
    /**
     * The API URL for exchanges rates
     *
     * @var string
     */
    private $exchangeRatesApiUrl;

    /**
     * THe exchange rates object
     *
     * @var object
     */
    private $exchangeRates;

    /**
     * The HTTP request service
     *
     * @var HttpRequestService
     */
    private $httpService;

    /**
     * The Currency Exchange object
     *
     * @var CurrencyExchange
     */
    private $currencyExchange;

    /**
     * The API response data
     *
     * @var mixed
     */
    private $apiData;

    /**
     * Class Constructor
     *
     * @param HttpRequestService $httpRequestService
     * @param CurrencyExchange $currencyExchange
     */
    public function __construct(HttpRequestService $httpRequestService, CurrencyExchange $currencyExchange)
    {
        $this->exchangeRatesApiUrl = 'https://api.exchangeratesapi.io/latest';
        $this->httpService = $httpRequestService;
        $this->currencyExchange = $currencyExchange;
    }

    /**
     *
     * Interface Implementation Methods
     *
    **/

    /**
     * Sets the exchange rates data
     *
     * @return self
     */
    public function setSourceData() : self
    {
        // set to exchange rates from response
        $this->apiData = $this->httpService->get($this->getExchangeRatesApiUrl());

        return $this;
    }

    /**
     * Outputs the card meta into object
     *
     * @param mixed $result
     * @return object
     */
    public function outputDataToObject() : object
    {
        if (empty($this->getApiData()) || $this->getApiData() === null) {
            return null;
        }

        return json_decode($this->getApiData());
    }

    /*
     * Getters
     */
    /**
     * Gets the exchange rates API URL
     *
     * @return string
     */
    public function getExchangeRatesApiUrl() : string
    {
        return $this->exchangeRatesApiUrl;
    }

    /**
     * Gets the exchange rates
     *
     * @return object
     */
    public function getExchangeRates() : object
    {
        return $this->exchangeRates;
    }

    /**
     * Gets the currency exchange class object
     *
     * @return CurrencyExchange
     */
    public function getCurrencyExchange() : CurrencyExchange
    {
        return $this->currencyExchange;
    }

    /**
     * Gets the raw API data
     *
     * @return string
     */
    public function getApiData() : string
    {
        return $this->apiData;
    }

    /*
     * Setters
     */

     /**
      * Sets the exhange rates API URL
      *
      * @param string $exchangeRatesApiUrl
      * @return self
      */
    public function setExchangeRatesApiUrl(string $exchangeRatesApiUrl) : self
    {
        $this->exchangeRatesApiUrl = $exchangeRatesApiUrl;

        return $this;
    }

    /**
     * Sets exchange rates
     *
     * @param object $exchangeRates
     * @return self
     */
    public function setExchangeRates(object $exchangeRates) : self
    {
        $this->exchangeRates = $exchangeRates;

        return $this;
    }

    /**
     * Sets API data
     *
     * @param mixed $apiData
     * @return self
     */
    public function setApiData($apiData) : self
    {
        $this->apiData = $apiData;

        return $this;
    }

    /**
     * Sets the currency exchange class object
     *
     * @param object $exchangeRates
     * @return self
     */
    public function setCurrencyExchange(object $exchangeRates) : self
    {
        $this->currencyExchange->setExchangeRates($exchangeRates);

        return $this;
    }
}
