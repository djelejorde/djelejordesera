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
class Bank
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
}
