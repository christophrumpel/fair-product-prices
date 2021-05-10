# Fair Product Prices

Calculate Fair Product Prices Based On Your Customer's Location (Purchasing Power Parity)

[![Latest Version on Packagist](https://img.shields.io/packagist/v/christophrumpel/fair-product-prices.svg?style=flat-square)](https://packagist.org/packages/christophrumpel/fair-product-prices)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/christophrumpel/fair-product-prices/run-tests?label=tests)](https://github.com/christophrumpel/fair-product-prices/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/christophrumpel/fair-product-prices/Check%20&%20fix%20styling?label=code%20style)](https://github.com/christophrumpel/fair-product-prices/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/christophrumpel/fair-product-prices.svg?style=flat-square)](https://packagist.org/packages/christophrumpel/fair-product-prices)

---

## Installation

You can install the package via composer:

```bash
composer require christophrumpel/fair-product-prices
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Christophrumpel\FairProductPrices\FairProductPricesServiceProvider" --tag="fair-product-prices-config"
```

This is the contents of the published config file:

```php
<?php

return [
    /*
    |--------------------------------------------------------------------------
    | You can override the ppp conversion factor for specific countries
    |--------------------------------------------------------------------------
    |
    */
    'pppConversionFactor' => [
        //'IT' => 0.9
    ],

    /*
    |--------------------------------------------------------------------------
    | Paddle credentials for creating a Paddle pay link
    |--------------------------------------------------------------------------
    |
    */
    'paddle' => [
        'vendor_id' => env('PADDLE_VENDOR_ID'),
        'auth_code' => env('PADDLE_AUTH_CODE'),
    ]

];

```

## Usage

```php
use Christophrumpel\FairProductPrices\Facades\FairProductPrices;

// Determine your customer's location
$customerLocation = FairProductPrices::getLocation('IP Address');

// Calculate a fair price
$defaultPrice = 100;
$fairPrice = FairProductPrices::getFairPrice($defaultPrice, $customerLocation->getCountryCode());
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Christoph Rumpel](https://github.com/christophrumpel)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
