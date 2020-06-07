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
     * Fetch the data from the data source
     *
     * @return void
     */
    public function fetchData();

    /**
     * Outputs the data to object
     *
     * @return void
     */
    public function outputDataToObject();
}
