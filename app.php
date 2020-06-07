<?php

declare(strict_types=1);

require_once __DIR__.'/vendor/autoload.php';

use DenverSera\CommissionTask\Services\JSONReaderService;
use DenverSera\CommissionTask\Services\CommissionFeeService;
use DenverSera\CommissionTask\Services\Http\HttpRequestService;
use DenverSera\CommissionTask\Services\Http\HttpResponseOutputterService;
use DenverSera\CommissionTask\Services\Normalizers\CardNormalizerService;
use DenverSera\CommissionTask\Entities\Transaction;
use DenverSera\CommissionTask\Entities\EuropeanUnionMembers;
use DenverSera\CommissionTask\Entities\CurrencyExchange;
use DenverSera\CommissionTask\DataProviders\ThirdPartyApiDataProvider;
use DenverSera\CommissionTask\ErrorHandlers\FileNotFoundErrorException;

// check if php has arguments
if (isset($argc)) {
    
    // checks the second parameter on CLI
    if (!isset($argv[1])) {
        throw new FileNotFoundErrorException('File name parameter not found. Filename should not be empty.', 'app.php');
    }

    // Call the JSON reader service to read the file
    $jsonReader = new JSONReaderService();

    $jsonData = $jsonReader->readByLine($argv[1])->getData();

    if (count($jsonData) > 0) {
        foreach ($jsonData as $data) {
            $transaction = new Transaction();
            $transaction->setBinNumber($data->bin);
            $transaction->setAmount($data->amount);
            $transaction->setCurrency($data->currency);

            // BIN request
            $binListCardMetaDataProvider = new ThirdPartyApiDataProvider(new HttpRequestService(), new HttpResponseOutputterService());
            $binListCardMetaDataProvider->setApiUrl('https://lookup.binlist.net/'. $data->bin);

            // get BIN API response and output to object
            $cardMeta = $binListCardMetaDataProvider->fetchData()->outputDataToObject();

            // normalize card meta into entities
            $cardNormalizer = new CardNormalizerService($cardMeta);
            $cardNormalizer->mapCountry('country');
            // another example if bank properties needs to be mapped
            $cardNormalizer->mapBank('bank');

            // get the normalized card entity
            $card = $cardNormalizer->getNormalizedCardEntity();

            // get the country code
            $country = $card->getCountry();
            $countryCode = $country->getProperty('alpha2');

            // Exchange rates
            $euCurrencyRatesDataProvider = new ThirdPartyApiDataProvider(new HttpRequestService(), new HttpResponseOutputterService());
            $euCurrencyRatesDataProvider->setApiUrl('https://api.exchangeratesapi.io/latest');

            // get EU currency rates API response and output to object
            $currencyRates = $euCurrencyRatesDataProvider->fetchData()->outputDataToObject();

            // set the response to Currency Exchange entity
            $currencyExchange = new CurrencyExchange();
            $currencyExchange->setExchangeRates($currencyRates);

            // instantiate the EuropeanMembers entity
            $euMembers = new EuropeanUnionMembers();

            // set the country codes that are member of EU
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
            
            // check if the country code from the Card object is member of EU
            $isEuMember = $euMembers->isEuMember($countryCode);
            
            // calculate the commission fee using the currency exhange and transaction data
            $commissionFeeService = new CommissionFeeService();
            $commissionFee = $commissionFeeService->calculate($transaction, $currencyExchange, $isEuMember);

            print_r($commissionFee . "\n");
        }
    }
}
