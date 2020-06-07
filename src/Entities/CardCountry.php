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
class CardCountry
{
    /**
     * The country data object where the card was issued
     *
     * @var object
     */
    private $country;
    
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
     * Gets a property within the Card Country entitry dynamically
     *
     * @param string $propertyName
     * @return mixed
     */
    public function getProperty(string $propertyName)
    {
        $country = $this->getCountry();

        if ($country === null || empty($country)) {
            throw new DataTypeMismatchErrorException('Country object is not defined.', 'CardCountry');
        }

        if (!isset($country->{$propertyName})) {
            throw new DataTypeMismatchErrorException('Property: '. $propertyName . ' is not defined in the country object.', 'CardCountry');
        }

        return $country->{$propertyName};
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
}
