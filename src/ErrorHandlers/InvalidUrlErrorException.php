<?php

declare(strict_types=1);

namespace DenverSera\CommissionTask\ErrorHandlers;

use DenverSera\CommissionTask\Interfaces\ErrorExceptionInterface;
use Exception;

class InvalidUrlErrorException extends Exception implements ErrorExceptionInterface
{
    /**
     * The error message string
     *
     * @var string
     */
    private $errorMessage;

    /**
     * The error source
     *
     * @var string
     */
    private $errorSource;

    /**
     * Class constructor
     *
     * @param string $errorMessage
     * @param string $errorSource
     */
    public function __construct(string $errorMessage, string $errorSource)
    {
        $this->errorMessage = $errorMessage;
        $this->errorSource = $errorSource;

        parent::__construct($errorMessage);
    }

    /**
     * Overriden toString function of Exception class
     *
     * @return string
     */
    public function __toString()
    {
        return "{$this->errorSource}: {$this->errorMessage}\n";
    }

    /**
     * Gets the error message
     *
     * @return string
     */
    public function getErrorMessage() : string
    {
        return $this->errorMessage;
    }

    /**
     * Gets the error source
     *
     * @return string
     */
    public function getErrorSource() : string
    {
        return $this->errorSource;
    }

    /**
     * Sets the error message
     *
     * @param string $errorMessage
     * @return self
     */
    public function setErrorMessage(string $errorMessage) : self
    {
        $this->errorMessage = $errorMessage;

        return $this;
    }

    /**
     * Sets the error source
     *
     * @param string $errorSource
     * @return self
     */
    public function setErrorSource(string $errorSource) : self
    {
        $this->errorSource = $errorSource;

        return $this;
    }
}
