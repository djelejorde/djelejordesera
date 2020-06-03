<?php

declare(strict_types=1);

namespace DenverSera\CommissionTask\Entities;

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
}
