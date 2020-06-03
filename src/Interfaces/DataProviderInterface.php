<?php

declare(strict_types=1);

namespace DenverSera\CommissionTask\Interfaces;

/**
 * DataProviderInterface
 *
 * This interface contains the set of rules for data providers such as data coming from external source or API
 */
interface DataProviderInterface
{
    /**
     * Sets the source data within the class
     *
     * @return void
     */
    public function setSourceData();
    
    /**
     * Outputs the data to object
     *
     * @return void
     */
    public function outputDataToObject();
}
