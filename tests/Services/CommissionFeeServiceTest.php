<?php

declare(strict_types=1);

namespace DenverSera\CommissionTask\Tests\Services;

use PHPUnit\Framework\TestCase;
use DenverSera\CommissionTask\Services\CommissionFeeService;
use DenverSera\CommissionTask\Entities\Transaction;
use DenverSera\CommissionTask\Entities\CurrencyExchange;

class CommissionFeeServiceTest extends TestCase
{
    /**
     * @var CommissionFeeService
     */
    private $commissionFeeService;

    public function setUp() : void
    {
        $this->commissionFeeService = new CommissionFeeService();
    }

    /**
     * @param string $isEuMember
     * @param float $expectation
     *
     * @dataProvider dataProviderForCalculateTesting
     */
    public function testCalculate(
        Transaction $transaction,
        CurrencyExchange $currencyExchange,
        bool $isEuMember,
        float $expectation
    ) : void {
        $this->assertEquals(
            $expectation,
            $this->commissionFeeService->calculate($transaction, $currencyExchange, $isEuMember)
        );
    }

    /**
     * Data provider function for calculate testing
     *
     * Note: The rates are fixed compared with the actual application
     *
     * @return array
     */
    public function dataProviderForCalculateTesting() : array
    {
        $rates = json_decode('{"rates":{"JPY":120.83,"USD":1.1174,"GBP":0.89083},"base":"EUR","date":"2020-06-02"}');

        return [
            'DK transaction' => [
                'transaction' => (new Transaction())
                                    ->setBinNumber('45717360')
                                    ->setAmount('100.00')
                                    ->setCurrency('EUR'),
                'currencyExchange' => (new CurrencyExchange())
                                        ->setExchangeRates($rates),
                'isEuMember' => true,
                'expectation' => 1.00,
            ],
            'LT transaction' => [
                'transaction' => (new Transaction())
                                    ->setBinNumber('516793')
                                    ->setAmount('50.00')
                                    ->setCurrency('USD'),
                'currencyExchange' => (new CurrencyExchange())
                                        ->setExchangeRates($rates),
                'isEuMember' => true,
                'expectation' => 0.45,
            ],
            'JP transaction' => [
                'transaction' => (new Transaction())
                                    ->setBinNumber('45417360')
                                    ->setAmount('10000.00')
                                    ->setCurrency('JPY'),
                'currencyExchange' => (new CurrencyExchange())
                                        ->setExchangeRates($rates),
                'isEuMember' => false,
                'expectation' => 1.66,
            ]
        ];
    }
}
