<?php

declare(strict_types=1);

namespace DenverSera\CommissionTask\Services;

use DenverSera\CommissionTask\Entities\Transaction;
use DenverSera\CommissionTask\Entities\CurrencyExchange;

/**
 * CommissionFeeService
 */
class CommissionFeeService
{
    /**
     * The commission rate for EU memnbers
     */
    const EU_COMMISSION_RATE = '0.01';

    /**
     * The commission rate for non-EU members
     */
    const NOT_EU_COMMISSION_RATE = '0.02';

    /**
     * Calculates commission fee based on being a member of EU
     *
     * @param Transaction $transaction
     * @param CurrencyExchange $currencyExchange
     * @param boolean $isEuMember
     * @return string
     */
    public function calculate(
        Transaction $transaction,
        CurrencyExchange $currencyExchange,
        bool $isEuMember = false
    ): string {
        // gets the amount transacted
        $amount = $transaction->getAmount();
        $toCurrency = $transaction->getCurrency();

        if ($amount === '') {
            return 0.0;
        }

        // if the transacted currency is not Euro
        // we need to get the converted amount since our base currency for computation is Euro
        if ($toCurrency !== 'EUR') {
            $exchangeRates = $currencyExchange->getExchangeRates();

            $rates = $exchangeRates ? $exchangeRates->rates : null;

            if ($rates !== null) {
                $toCurrencyRate = (string) $rates->{$toCurrency};
                
                // currency rate conversion
                $amount = bcdiv($amount, $toCurrencyRate, 4);
            }
        }
      
        if ($isEuMember) {
            $commission = bcmul(self::EU_COMMISSION_RATE, $amount, 4);
        } else {
            $commission = bcmul(self::NOT_EU_COMMISSION_RATE, $amount, 4);
        }
        
        // return the commission with two decimal places
        return number_format((float) $commission, 2);
    }
}
