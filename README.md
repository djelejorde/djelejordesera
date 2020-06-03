## DenverSera
A commission task service which computes commission fee based on an existing transaction data

## Tech/framework used
<b>Built with</b>
- PHP 7.3
- PHPUnit

## Installation
After cloning the repository, please make sure to run this command in your terminal
```
composer install
```

## Third Party APIs
The project uses third-party APIs for its calculations
- BIN Lookup: https://binlist.net/
- Currency Exchange Rates: https://exchangeratesapi.io/

## Tests
Run these command to test the code.
```
composer run test
```

## Source Data JSON File Example
```
{"bin":"45717360","amount":"100.00","currency":"EUR"}
{"bin":"516793","amount":"50.00","currency":"USD"}
{"bin":"45417360","amount":"10000.00","currency":"JPY"}
{"bin":"41417360","amount":"130.00","currency":"USD"}
{"bin":"4745030","amount":"2000.00","currency":"GBP"}

```
## How to use?
Assuming PHP code is in `app.php` and your source data is in `input.txt`, here's an example command on how to use the code.
```
php app.php input.txt
```
