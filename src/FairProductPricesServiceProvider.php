<?php

namespace Christophrumpel\FairProductPrices;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FairProductPricesServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('fair-product-prices')
            ->hasConfigFile();

        $this->app->bind('fair-product-prices', function() {
            return new FairProductPrices();
        });
    }
}
