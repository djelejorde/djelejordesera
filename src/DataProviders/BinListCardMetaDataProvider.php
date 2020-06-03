<?php

declare(strict_types=1);

namespace DenverSera\CommissionTask\DataProviders;

use DenverSera\CommissionTask\Interfaces\DataProviderInterface;
use DenverSera\CommissionTask\Services\HttpRequestService;
use DenverSera\CommissionTask\Entities\Card;

/**
 * BinListCardMetaDataProvider Class
 *
 * Provides card metadata details such as bank issuer, type of card, country issued, etc.
 *
 * This uses card metadata from https://binlist.net/
 *
 * List of abbreviations that is used within this class:
 *
 * BIN - Bank Identification Number
 * URL - Uniform Resource Location
 *
 */
class BinListCardMetaDataProvider implements DataProviderInterface
{
    /**
     * The look up URL to use to get the card metadata
     *
     * It can be a internal URL or an external API endpoint.
     *
     * @var string
     */
    private $binLookUpUrl;

    /**
     * The main data object from the API response
     *
     * @var mixed
     */
    private $binMeta;

    /**
     * The card BIN
     *
     * @var string
     */
    private $binNumber;

    /**
     * The HTTP request service
     *
     * @var HttpRequestService
     */
    private $httpService;


    /**
     * The card entity
     *
     * @var Card
     */
    private $card;
    
    /**
     * Class constructor
     *
     * @param HttpRequestService $httpRequestService
     * @param Card $card
     */
    public function __construct(HttpRequestService $httpRequestService, Card $card)
    {
        $this->binLookUpUrl = 'https://lookup.binlist.net/';
        $this->httpService = $httpRequestService;
        $this->card = $card;
    }

    /**
     *
     * Interface Implementation Methods
     *
    **/

    /**
     * Requests data from given BIN lookup URL using GET
     *
     * @return self
     */
    public function setSourceData() : self
    {
        // set to binMeta upon request
        $this->binMeta = $this->httpService->get($this->binLookUpUrl . $this->binNumber);

        return $this;
    }

    /**
     * Outputs the card meta into object
     *
     * @param mixed $result
     * @return object
     */
    public function outputDataToObject() : object
    {
        if (empty($this->binMeta) || $this->binMeta === null) {
            return null;
        }

        return json_decode($this->binMeta);
    }

    /*
     * Getters
     */

    /**
     * Gets the BIN lookup URL
     *
     * @return string
     */
    public function getBinLookUpUrl() : string
    {
        return $this->binLookUpUrl;
    }

    /**
     * Gets the BIN meta object
     *
     * @return mixed
     */
    public function getBinMeta()
    {
        return $this->binMeta;
    }

    /**
     * Gets the card object
     *
     * @return Card
     */
    public function getCard() : Card
    {
        return $this->card;
    }

    /**
     * Gets the BIN Number
     *
     * @return string
     */
    public function getBinNumber() : string
    {
        return $this->binNumber;
    }

    /*
     * Setters
     */

    /**
     * Sets the BIN lookup URL
     *
     * @param string $binLookUpUrl
     * @return void
     */
    public function setBinListLookUpUrl(string $binLookUpUrl) : void
    {
        $this->binLookUpUrl = $binLookUpUrl;
    }

    /**
     * Sets the BIN number
     *
     * @param string $binNumber
     * @return self
     */
    public function setBinNumber(string $binNumber) : self
    {
        $this->binNumber = $binNumber;

        return $this;
    }

    /**
     * Sets the Card object
     *
     * @param object $cardMeta
     * @return self
     */
    public function setCard(object $cardMeta) : self
    {
        $this->card->setCard($cardMeta);

        return $this;
    }
}
