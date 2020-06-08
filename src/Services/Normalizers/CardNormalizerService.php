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
     * The card entity object
     *
     * @var [type]
     */
    private $card;

    public function __construct()
    {
        $this->card = new Card();
    }

    /**
     * Maps Bank Entity within Card Entity
     *
     * @param Bank $bank
     * @return Card
     */
    public function mapBankIntoCard(Bank $bank) : Card
    {
        if (!$bank instanceof Bank) {
            throw new DataTypeMismatchErrorException('Mapping failed. Bank parameter is not an instance of Bank class.\n', 'CardNormalizerService@mapBankIntoCard');
        }

        return $this->card->setBank($bank);
    }

    /**
     * Maps Country Entity within Card Entity
     *
     * @param Country $country
     * @return Card
     */
    
    public function mapCountryIntoCard(Country $country) : Card
    {
        if (!$country instanceof Country) {
            throw new DataTypeMismatchErrorException('Mapping failed. Country parameter is not an instance of Country class.\n', 'CardNormalizerService@mapCountryIntoCard');
        }

        return $this->card->setCountry($country);
    }
}
