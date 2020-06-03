<?php

declare(strict_types=1);

require_once __DIR__.'/vendor/autoload.php';

use DenverSera\CommissionTask\Services\JSONReaderService;
use DenverSera\CommissionTask\Services\CommissionFeeService;
use DenverSera\CommissionTask\Services\HttpRequestService;
use DenverSera\CommissionTask\Entities\Transaction;
use DenverSera\CommissionTask\Entities\EuropeanUnionMembers;
use DenverSera\CommissionTask\Entities\CurrencyExchange;
use DenverSera\CommissionTask\Entities\Card;
use DenverSera\CommissionTask\DataProviders\BinListCardMetaDataProvider;
use DenverSera\CommissionTask\DataProviders\EuCurrencyExchangeDataProvider;

// check if php has arguments
if (isset($argc)) {
    
    // checks the second parameter on CLI
    if (isset($argv[1])) {
        // Call the JSON reader service to read the file
        $jsonReader = new JSONReaderService();
    
        $jsonData = $jsonReader->readByLine($argv[1])->getData();

        if(count($jsonData) > 0) {
            
            foreach($jsonData as $data) {
                $transaction = new Transaction();
                $transaction->setBinNumber($data->bin);
                $transaction->setAmount($data->amount);
                $transaction->setCurrency($data->currency);

                // BIN request
                $binListCardMetaDataProvider = new BinListCardMetaDataProvider(new HttpRequestService(), new Card());
                $binListCardMetaDataProvider->setBinNumber($data->bin);

                // get BIN API response
                $binMeta = $binListCardMetaDataProvider->setSourceData()->outputDataToObject();

                // set the response to Card object
                $cardMeta = $binListCardMetaDataProvider->setCard($binMeta)->getCard();
                $card = $cardMeta->getCard();

                // get the country code
                $countryCode = $card->country->alpha2;

                // Exchange rates
                $euCurrencyRatesProvider = new EuCurrencyExchangeDataProvider(new HttpRequestService(), new CurrencyExchange());

                // get the EU rates API response
                $currencyRates = $euCurrencyRatesProvider->setSourceData()->outputDataToObject();

                //set the response to Currency Exchange object
                $currencyExchange = $euCurrencyRatesProvider->setCurrencyExchange($currencyRates)->getCurrencyExchange();

                // Instantiate the EuropeanMembers
                $euMembers = new EuropeanUnionMembers();

                // Set the country codes that are member of EU
                $euMembers->setMemberCountryCodes([
                    'AT',
                    'BE',
                    'BG',
                    'CY',
                    'CZ',
                    'DE',
                    'DK',
                    'EE',
                    'ES',
                    'FI',
                    'FR',
                    'GR',
                    'HR',
                    'HU',
                    'IE',
                    'IT',
                    'LT',
                    'LU',
                    'LV',
                    'MT',
                    'NL',
                    'PO',
                    'PT',
                    'RO',
                    'SE',
                    'SI',
                    'SK'
                ]);
                
                // Check if the country code from the Card object is member of EU
                $isEuMember = $euMembers->isEuMember($countryCode);
                
                // Calculate the commission fee using the currency exhange and transaction data
                $commissionFeeService = new CommissionFeeService();
                $commissionFee = $commissionFeeService->calculate($transaction, $currencyExchange, $isEuMember);

                print_r($commissionFee . "\n");
            }

        }
    }

}
