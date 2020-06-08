<?php

declare(strict_types=1);

namespace DenverSera\CommissionTask\Entities;

use DenverSera\CommissionTask\ErrorHandlers\DataTypeMismatchErrorException;
use stdClass;

/**
 * CardCountry class
 *
 * Holds country metadata details such as country code, latitude, longitude, currency.
 *
 *
 */
class Country
{
    /**
     * The country data object where the card was issued
     *
     * @var object
     */
    private $country;

    /**
     * The country code
     *
     * @var string
     */
    private $countryCode;
    
    /**
     * Class constructor
     */
    public function __construct()
    {
        $this->country = new stdClass;
    }

    /*
     * Getters
     */

    /**
     * Returns the country object
     *
     * @return object
     */
    public function getCountry() : object
    {
        return $this->country;
    }

    /**
     * Gets the country code
     *
     * @return string
     */
    public function getCountryCode() : string
    {
        return $this->countryCode;
    }

    /*
     * Setters
     */

    /**
     * Sets the value for country object
     *
     * @param object $country
     * @return self
     */
    public function setCountry(object $country) : self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Sets the country code
     *
     * @param string $countryCode
     * @return self
     */
    public function setCountryCode(string $countryCode) : self
    {
        $this->countryCode = $countryCode;

        return $this;
    }
}
