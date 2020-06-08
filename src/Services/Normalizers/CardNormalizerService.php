<?php

declare(strict_types=1);

namespace DenverSera\CommissionTask\Services\Normalizers;

use DenverSera\CommissionTask\Entities\Card;
use DenverSera\CommissionTask\Entities\Bank;
use DenverSera\CommissionTask\Entities\Country;
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
    }

    /**
     * Maps the country object to Card Country entity
     *
     * @param string $countryPropertyName
     * @return Country
     */
    private function mapCountry(string $countryPropertyName) : Country
    {
        if ($this->cardObject === null || empty($this->cardObject)) {
            throw new DataTypeMismatchErrorException('Mapping failed. Card object is not defined or empty.', 'CardNormalizer@mapCountry');
        }

        if (!isset($this->cardObject->{$countryPropertyName}) && gettype($this->cardObject->{$countryPropertyName}) !== 'object') {
            throw new DataTypeMismatchErrorException('Country is not defined in the card object.', 'CardNormalizer@mapCountry');
        }

        $country = $this->cardObject->{$countryPropertyName};
        
        return (new Country())
                ->setCountry($country)
                ->setCountryCode($country->alpha2);
    }

    /**
     * Maps the bank object to Card Bank entity
     *
     * @param string $cardPropertyName
     * @return void
     */
    private function mapBank(string $bankPropertyName) : Bank
    {
        if ($this->cardObject === null || empty($this->cardObject)) {
            throw new DataTypeMismatchErrorException('Mapping failed. Card object is not defined or empty.', 'CardNormalizer@mapBank');
        }

        if (!isset($this->cardObject->{$bankPropertyName}) && gettype($this->cardObject->{$bankPropertyName}) !== 'object') {
            throw new DataTypeMismatchErrorException('Bank is not defined in the card object.', 'CardNormalizer@mapBank');
        }

        return (new Bank())
                ->setBank($this->cardObject->{$bankPropertyName});
    }

    /**
     * Gets the normalized Card entity object
     *
     * @return Card
     */
    public function getNormalizedCardEntity() : Card
    {
        try {
            // set the bank within card entity
            $this->card->setBank($this->mapBank('bank'));

            // set the country within the card entity
            $this->card->setCountry($this->mapCountry('country'));

            return $this->card;
        } catch (DataTypeMismatchErrorException $e) {
            echo $e->getMessage();
        }
    }
}
