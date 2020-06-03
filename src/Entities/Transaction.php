<?php

declare(strict_types=1);

namespace DenverSera\CommissionTask\Entities;

/**
 * Transaction Class
 */
class Transaction
{
    private $binNumber;
    private $amount;
    private $currency;

    /*
    * Getters
    */

    /**
     * Gets BIN number
     *
     * @return string
     */
    public function getBinNumber() : string
    {
        return $this->binNumber;
    }

    /**
     * Gets transaction amount
     *
     * @return string
     */
    public function getAmount() : string
    {
        return $this->amount;
    }

    /**
     * Gets currency based from the transaction amount
     *
     * @return string
     */
    public function getCurrency() : string
    {
        return $this->currency;
    }

    /*
    * Setters
    */

    /**
     * Sets BIN bumber
     *
     * @param string $binNumber
     * @return self
     */
    public function setBinNumber(string $binNumber) : self
    {
        $this->binNumber = $binNumber;

        return $this;
    }

    /**
     * Sets transaction amount
     *
     * @param string $amount
     * @return self
     */
    public function setAmount(string $amount) : self
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Sets currency that is based on the amount transacted
     *
     * @param string $currency
     * @return self
     */
    public function setCurrency(string $currency) : self
    {
        $this->currency = $currency;

        return $this;
    }
}
