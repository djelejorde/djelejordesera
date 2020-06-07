<?php

declare(strict_types=1);

namespace DenverSera\CommissionTask\Entities;

use DenverSera\CommissionTask\Entities\CardBank;
use DenverSera\CommissionTask\Entities\CardCountry;

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
     * @return CardCountry
     */
    public function getCountry() : CardCountry
    {
        return $this->card->country;
    }

    /**
     * Gets the card bank entity
     *
     * @return CardBank
     */
    public function getBank() : CardBank
    {
        return $this->card->bank;
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
     * @param CardBank $bank
     * @return self
     */
    public function setBank(CardBank $bank) : self
    {
        $this->card->{'bank'} = $bank;

        return $this;
    }

    /**
     * Sets the card country entity
     *
     * @param CardCountry $country
     * @return self
     */
    public function setCountry(CardCountry $country) : self
    {
        $this->card->{'country'} = $country;

        return $this;
    }
}
