<?php

declare(strict_types=1);

namespace DenverSera\CommissionTask\Entities;

use DenverSera\CommissionTask\Entities\Bank;
use DenverSera\CommissionTask\Entities\Country;

use stdClass;

/**
 * Card class
 *
 * Holds card metadata details such as bank issuer, type of card, country issued, etc.
 *
 *
 */
class Card
{
    /**
     * The card data object specific about the country where it was issued
     *
     * @var object
     */
    private $card;

    /**
     * The Bank entity
     *
     * @var Bank
     */
    private $bank;

    /**
     * The Country entity
     *
     * @var Country
     */
    private $country;

    /**
     * Class constructor
     */
    public function __construct()
    {
        $this->card = new stdClass;
    }

    /*
     * Getters
     */

    /**
     * Returns the card object
     *
     * @return object
     */
    public function getCard() : object
    {
        return $this->card;
    }

    /**
     * Gets the card country entity
     *
     * @return Country
     */
    public function getCountry() : Country
    {
        return $this->country;
    }

    /**
     * Gets the card bank entity
     *
     * @return Bank
     */
    public function getBank() : Bank
    {
        return $this->bank;
    }

    /*
     * Setters
     */

    /**
     * Sets the value for card object
     *
     * @param object $card
     * @return self
     */
    public function setCard(object $card) : self
    {
        $this->card = $card;

        return $this;
    }

    /**
     * Sets the card bank entity
     *
     * @param Bank $bank
     * @return self
     */
    public function setBank(Bank $bank) : self
    {
        $this->bank = $bank;

        return $this;
    }

    /**
     * Sets the card country entity
     *
     * @param Country $country
     * @return self
     */
    public function setCountry(Country $country) : self
    {
        $this->country = $country;

        return $this;
    }
}
