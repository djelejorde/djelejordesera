<?php

declare(strict_types=1);

namespace DenverSera\CommissionTask\Services\Normalizers;

use DenverSera\CommissionTask\Entities\Bank;
use DenverSera\CommissionTask\ErrorHandlers\DataTypeMismatchErrorException;

class BankNormalizerService
{
    /**
     * Maps the bank object to Bank entity
     *
     * @param object $bankObject
     * @return Bank
     */
    public function mapBank(object $bankObject) : Bank
    {
        // if (count(get_object_vars($bankObject)) === 0 || $bankObject === null) {
        //     throw new DataTypeMismatchErrorException("Mapping failed. Bank object is not defined or empty.\n", 'BankNormalizerService@mapBank');
        // }

        return (new Bank())
                ->setBank($bankObject);
    }
}
