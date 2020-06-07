<?php

declare(strict_types=1);

namespace DenverSera\CommissionTask\Entities;

use DenverSera\CommissionTask\ErrorHandlers\EmptyDataErrorException;

/**
 * EuropeanUnionMembers
 */
class EuropeanUnionMembers
{
    private $memberCountryCodes;

    public function __construct()
    {
        $this->memberCountryCodes = [];
    }

    /**
     * Checks if a given country code is a member of EU
     *
     * @param string $countryCode
     * @return boolean
     */
    public function isEuMember(string $countryCode) : bool
    {
        if (count($this->memberCountryCodes) === 0) {
            throw new EmptyDataErrorException('Member codes empty. Assign EU country codes first.', 'EuropeanUnionMembers@isEuMember');
        }

        return in_array($countryCode, $this->memberCountryCodes);
    }

    /**
     * Gets the EU members country codes
     *
     * @return array
     */
    public function getMemberCountryCodes() : array
    {
        return $this->memberCountryCodes;
    }

    /**
     * Sets the EU member country codes
     *
     * @param array $memberCountryCodes
     * @return self
     */
    public function setMemberCountryCodes(array $memberCountryCodes) : self
    {
        $this->memberCountryCodes = $memberCountryCodes;

        return $this;
    }
}
