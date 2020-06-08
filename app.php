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
use DenverSera\CommissionTask\Entities\Bank;
use DenverSera\CommissionTask\Entities\Card;
use DenverSera\CommissionTask\Entities\Country;
use DenverSera\CommissionTask\ErrorHandlers\DataTypeMismatchErrorException;
use DenverSera\CommissionTask\ErrorHandlers\EmptyDataErrorException;
use DenverSera\CommissionTask\ErrorHandlers\FileNotFoundErrorException;
use DenverSera\CommissionTask\ErrorHandlers\MissingBankErrorException;
use DenverSera\CommissionTask\ErrorHandlers\MissingCountryErrorException;
use DenverSera\CommissionTask\Services\Normalizers\BankNormalizerService;
use DenverSera\CommissionTask\Services\Normalizers\CountryNormalizerService;

// check if php has arguments
if (isset($argc)) {
    try {
        // checks the second parameter on CLI
        if (!isset($argv[1])) {
            throw new FileNotFoundErrorException('File name parameter not found. Filename should not be empty.', 'app.php');
        }

        // Fetch exchange rates
        $euCurrencyRatesDataProvider = new ThirdPartyApiDataProvider(new HttpRequestService(), new HttpResponseOutputterService());
        $euCurrencyRatesDataProvider->setApiUrl('https://api.exchangeratesapi.io/latest');
 
        // get EU currency rates API response and output to object
        $currencyRates = $euCurrencyRatesDataProvider->fetchData()->outputDataToObject();

        // set the response to Currency Exchange entity
        $currencyExchange = new CurrencyExchange();
        $currencyExchange->setExchangeRates($currencyRates);
    } catch (Exception $e) {
        echo $e->getMessage();

        exit;
    }

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

    // Call the JSON reader service to read the file
    $jsonReader = new JSONReaderService();

    $jsonData = $jsonReader->readByLine($argv[1])->getData();

    if (count($jsonData) > 0) {
        foreach ($jsonData as $data) {
            $transaction = new Transaction();
            $transaction->setBinNumber($data->bin);
            $transaction->setAmount($data->amount);
            $transaction->setCurrency($data->currency);

            try {
                // BIN request
                $binListCardMetaDataProvider = new ThirdPartyApiDataProvider(new HttpRequestService(), new HttpResponseOutputterService());
                $binListCardMetaDataProvider->setApiUrl('https://lookup.binlist.net/'. $data->bin);
            

                // get BIN API response and output to object
                $cardMeta = $binListCardMetaDataProvider->fetchData()->outputDataToObject();

                // normalize card meta into entities
                if (isset($cardMeta->bank)) {
                    $bankNormalizer = new BankNormalizerService();
                    $bankObject = $bankNormalizer->mapBank($cardMeta->bank);
                }

                if (isset($cardMeta->country)) {
                    $countryNormalizer = new CountryNormalizerService();
                    $countryObject = $countryNormalizer->mapCountry($cardMeta->country);
                } else {
                    throw new MissingCountryErrorException('Missing country meta from BIN lookup.\n', 'app.php');
                }
                
                $cardNormalizer = new CardNormalizerService();

                if (!$bankObject instanceof Bank) {
                    throw new MissingBankErrorException('Missing bank meta from BIN lookup.\n', 'app.php');
                } else {
                    $cardObject = $cardNormalizer->mapBankIntoCard($bankObject);
                }

                if (!$countryObject instanceof Country) {
                    throw new MissingCountryErrorException('Missing country meta from BIN lookup.\n', 'app.php');
                } else {
                    $cardObject = $cardNormalizer->mapCountryIntoCard($countryObject);
                }

                // end normalization
                
                // set the card meta to Card object
                $cardObject->setCard($cardMeta);

                // get the country code
                $countryCode = $countryObject->getCountryCode();

                // check if the country code from the Card object is member of EU
                $isEuMember = $euMembers->isEuMember($countryCode);

                // calculate the commission fee using the currency exhange and transaction data
                $commissionFeeService = new CommissionFeeService();
                $commissionFee = $commissionFeeService->calculate($transaction, $currencyExchange, $isEuMember);

                print_r($commissionFee . "\n");
            } catch (MissingCountryErrorException $e) {
                echo $e->getMessage();
            } catch (MissingBankErrorException $e) {
                echo $e->getMessage();
            } catch (DataTypeMismatchErrorException $e) {
                echo $e->getMessage();

                break;
            } catch (EmptyDataErrorException $e) {
                echo $e->getMessage();

                break;
            } catch (Exception $e) {
                echo $e->getMessage();

                break;
            }
        }
    }
}
