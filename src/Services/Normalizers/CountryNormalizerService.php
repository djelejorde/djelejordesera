<?php

declare(strict_types=1);

namespace DenverSera\CommissionTask\Services\Normalizers;

use DenverSera\CommissionTask\Entities\Country;
use DenverSera\CommissionTask\ErrorHandlers\DataTypeMismatchErrorException;
use stdClass;

class CountryNormalizerService
{
    const COUNTRY_CODE_KEY = 'alpha2';

    /**
     * Maps the country object to Country entity
     *
     * @param object $countryObject
     * @return Country
     */
    public function mapCountry(object $countryObject) : Country
    {
        if (count(get_object_vars($countryObject)) === 0 || $countryObject === null) {
            throw new DataTypeMismatchErrorException('Mapping failed. Country object is not defined or empty.\n', 'CountryNormalizerService@mapCountry');
        }

        if (!isset($countryObject->{self::COUNTRY_CODE_KEY})) {
            throw new DataTypeMismatchErrorException("Mapping failed. Country code key {self::COUNTRY_CODE_KEY} is not an existing within country object\n", 'CountryNormalizerService@mapCountry');
        }

        return (new Country())
                ->setCountry($countryObject)
                ->setCountryCode($countryObject->{self::COUNTRY_CODE_KEY});
    }
}
