<?php

namespace Christophrumpel\FairProductPrices\Tests;

use Christophrumpel\FairProductPrices\FairProductPricesServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Spatie\\FairProductPrices\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            FairProductPricesServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        include_once __DIR__.'/../database/migrations/create_fair-product-prices_table.php.stub';
        (new \CreatePackageTable())->up();
        */
    }

    public function getLocationTestData(array $dataToMerge = []): array
    {
        return array_merge([
            "ip" => "11.217.42.113",
            "country_code" => "AT",
            "country_name" => "Austria",
            "region_code" => "3",
            "region_name" => "Vienna",
            "city" => "Vienna",
            "zip_code" => "1230",
            "time_zone" => "Europe/Vienna",
            "latitude" => 48.210,
            "longitude" => 16.3634,
            "metro_code" => 0,
        ], $dataToMerge);
    }
}
