<?php

declare(strict_types=1);

namespace DenverSera\CommissionTask\Entities;

use DenverSera\CommissionTask\ErrorHandlers\DataTypeMismatchErrorException;
use stdClass;

/**
 * CardBank class
 *
 * Holds bank metadata details such as name, website, city, phone.
 *
 *
 */
class CardBank
{
    /**
     * The bank data object where the card was issued
     *
     * @var object
     */
    private $bank;
    
    /**
     * Class constructor
     */
    public function __construct()
    {
        $this->bank = new stdClass;
    }

    /*
     * Getters
     */

    /**
     * Returns the bank object
     *
     * @return object
     */
    public function getBank() : object
    {
        return $this->bank;
    }

    /*
     * Setters
     */

    /**
     * Sets the value for bank object
     *
     * @param object $bank
     * @return self
     */
    public function setBank(object $bank) : self
    {
        $this->bank = $bank;

        return $this;
    }

    /**
     * Gets a property within the Card Bank entitry dynamically
     *
     * @param string $propertyName
     * @return mixed
     */
    public function getProperty(string $propertyName)
    {
        $bank = $this->getBank();

        if ($bank === null || empty($bank)) {
            throw new DataTypeMismatchErrorException('Bank object is not defined.', 'CardBank');
        }

        if (!isset($bank->{$propertyName})) {
            throw new DataTypeMismatchErrorException('Property: '. $propertyName . ' is not defined in the bank object.', 'CardBank');
        }

        return $bank->{$propertyName};
    }
}
