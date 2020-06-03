<?php

declare(strict_types=1);

namespace DenverSera\CommissionTask\Interfaces;

use DenverSera\CommissionTask\Entities\File\File;

/**
 * FileReaderInterface
 *
 * This interface set rules for functions of a file reader class
 */
interface FileReaderInterface
{
    /**
     * Reads a file by line from a given file path URL
     *
     * @param string $filePath
     * @return void
     */
    public function readByLine(string $filePath);
}
