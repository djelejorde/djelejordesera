<?php

declare(strict_types=1);

namespace DenverSera\CommissionTask\Services\Normalizers;

use DenverSera\CommissionTask\Entities\Card;
use DenverSera\CommissionTask\Entities\CardBank;
use DenverSera\CommissionTask\Entities\CardCountry;
use DenverSera\CommissionTask\ErrorHandlers\DataTypeMismatchErrorException;

class CardNormalizerService
{
    /**
     * The card entity
     *
     * @var Card
     */
    private $card;

    /**
     * The card country entity
     *
     * @var CardCountry
     */
    private $cardCountry;

    /**
     * The card bank entity
     *
     * @var CardBank
     */
    private $cardBank;

    /**
     * The card object
     *
     * @var object
     */
    private $cardObject;

    /**
     * Class constructor
     *
     * @param object $cardObject
     */
    public function __construct(object $cardObject)
    {
        $this->cardObject = $cardObject;

        $this->card = new Card();
        $this->cardCountry = new CardCountry();
        $this->cardBank = new CardBank();
    }

    /**
     * Maps the country object to Card Country entity
     *
     * @param string $cardPropertyName
     * @return void
     */
    public function mapCountry(string $cardPropertyName) : void
    {
        if ($this->cardObject === null || empty($this->cardObject)) {
            throw new DataTypeMismatchErrorException('Mapping failed. Card object is not defined or empty.', 'CardNormalizer@mapCountry');
        }

        if (!isset($this->cardObject->{$cardPropertyName}) && gettype($this->cardObject->{$cardPropertyName}) !== 'object') {
            throw new DataTypeMismatchErrorException('Country is not defined in the card object.', 'CardNormalizer@mapCountry');
        }

        $this->cardCountry->setCountry($this->cardObject->{$cardPropertyName});
    }

    /**
     * Maps the bank object to Card Bank entity
     *
     * @param string $cardPropertyName
     * @return void
     */
    public function mapBank(string $bankPropertyName) : void
    {
        if ($this->cardObject === null || empty($this->cardObject)) {
            throw new DataTypeMismatchErrorException('Mapping failed. Card object is not defined or empty.', 'CardNormalizer@mapBank');
        }

        if (!isset($this->cardObject->{$bankPropertyName}) && gettype($this->cardObject->{$bankPropertyName}) !== 'object') {
            throw new DataTypeMismatchErrorException('Bank is not defined in the card object.', 'CardNormalizer@mapBank');
        }

        $this->cardBank->setBank($this->cardObject->{$bankPropertyName});
    }

    /**
     * Gets the normalized Card entity object
     *
     * @return Card
     */
    public function getNormalizedCardEntity() : Card
    {
        $this->card->setBank($this->cardBank);

        $this->card->setCountry($this->cardCountry);

        return $this->card;
    }
}
