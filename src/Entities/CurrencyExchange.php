<?php

declare(strict_types=1);

namespace DenverSera\CommissionTask\Entities;

/**
 * Currency Exchange Class
 *
 * Holds the currency exchange entity which provides data such as exchange rates
 */
class CurrencyExchange
{
    /**
     * The exchanges rates
     *
     * @var object
     */
    private $exchangeRates;

    /*
    * Getters
    */

    /**
     * Gets the exchange rates data
     *
     * @return object|null
     */
    public function getExchangeRates() : ?object
    {
        return $this->exchangeRates;
    }

    /*
    * Setters
    */

    /**
     * Sets the exchange rates data
     *
     * @param object $exchangeRates
     * @return self
     */
    public function setExchangeRates(object $exchangeRates) : self
    {
        $this->exchangeRates = $exchangeRates;

        return $this;
    }
}
