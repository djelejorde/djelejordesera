<?php

declare(strict_types=1);

namespace DenverSera\CommissionTask\Services;

use DenverSera\CommissionTask\ErrorHandlers\FileNotFoundErrorException;
use DenverSera\CommissionTask\Interfaces\FileReaderInterface;
use Exception;
use stdClass;

class JSONReaderService implements FileReaderInterface
{
    /**
     * The read data from JSON
     *
     * @var array
     */
    private $data;

    /**
     * Reads a json file line by line
     *
     * @param string $fileUrl
     * @return self
     */
    public function readByLine(string $fileUrl) : self
    {
        try {
            $file = fopen($fileUrl, 'r', true);
            $data = [];

            if ($file === false) {
                throw new FileNotFoundErrorException("File: {$fileUrl} not found.", 'JSONReaderService@readByLine');
            }

            while (!feof($file)) {
                $line = fgets($file);

                $data[] = json_decode((string) $line);
            }

            fclose($file);

            $this->data = $data;

            return $this;
        } catch (Exception $e) {
            throw new FileNotFoundErrorException($e->getMessage(), 'JSONReaderService@readByLine');
        }
    }

    /**
     * Gets the read data
     *
     * @return array|null
     */
    public function getData() : ?array
    {
        return $this->data;
    }
}
