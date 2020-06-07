<?php

declare(strict_types=1);

namespace DenverSera\CommissionTask\Services\Http;

use DenverSera\CommissionTask\ErrorHandlers\DataTypeMismatchErrorException;

/**
 * HttpResponseOutputterService
 */
class HttpResponseOutputterService
{
    /**
     * Outputs the response to object
     *
     * @param mixed $rawResponse
     * @return object
     */
    public function outputResponseToObject($rawResponse) : object
    {
        if (empty($rawResponse) || $rawResponse === null) {
            throw new DataTypeMismatchErrorException('Cannot convert response to object with empty value.', 'HttpResponseOutputter@outputResponseToObject');
        }

        return json_decode($rawResponse);
    }

    /**
     * Outputs the response to array
     *
     * @param mixed $rawResponse
     * @return array
     */
    public function outputResponseToArray($rawResponse) : array
    {
        if (empty($rawResponse) || $rawResponse === null) {
            throw new DataTypeMismatchErrorException('Cannot convert response to array with empty value.', 'HttpResponseOutputter@outputResponseToArray');
        }

        return json_decode($rawResponse, true);
    }
}
