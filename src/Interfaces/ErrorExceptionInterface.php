<?php

declare(strict_types=1);

namespace DenverSera\CommissionTask\Interfaces;

interface ErrorExceptionInterface
{
    public function setErrorSource(string $errorMessage);

    public function setErrorMessage(string $errorSource);
}
