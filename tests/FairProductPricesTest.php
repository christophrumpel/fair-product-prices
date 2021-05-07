<?php

namespace Christophrumpel\FairProductPrices\Tests;

use Christophrumpel\FairProductPrices\CustomerLocation;
use Christophrumpel\FairProductPrices\Facades;
use Illuminate\Support\Facades\Http;

class FairProductPricesTest extends TestCase
{
    /** @test **/
    public function it_gets_customers_location_through_IP(): void
    {
        // Arrange
        Http::fake([
            'freegeoip.app/*' => Http::response($this->getLocationTestData()),
        ]);

    	// Act
    	$customerLocation = Facades\FairProductPricesFacade::getLocation('11.111.11.113');

    	// Assert
        $this->assertInstanceOf(CustomerLocation::class, $customerLocation);
        $this->assertEquals('AT', $customerLocation->getCountryCode());
    }

    /** @test **/
    public function it_gets_fair_price_for_given_customer_location(): void
    {
    	// Arrange
        Http::fake([
            'purchasing-power-parity.com/*' => Http::response(['ppp' => [
                'pppConversionFactor' => 0.9
            ]]),
        ]);
    	$customerLocation = new CustomerLocation($this->getLocationTestData());

        // Act
        $fairPrice = Facades\FairProductPricesFacade::getFairPrice(100, $customerLocation->getCountryCode());

        // Assert
        $this->assertEquals(90, $fairPrice);
    }

    /** @test **/
    public function it_rounds_fair_prices_for_given_customer_location(): void
    {
        // Arrange
        Http::fake([
            'purchasing-power-parity.com/*' => Http::response(['ppp' => [
                'pppConversionFactor' => 0.874636277820489
            ]]),
        ]);
        $customerLocation = new CustomerLocation($this->getLocationTestData());

        // Act
        $fairPrice = Facades\FairProductPricesFacade::getFairPrice(99.99, $customerLocation->getCountryCode());

        // Assert
        $this->assertEquals(87.45, $fairPrice);
    }

    /** @test **/
    public function it_calculates_a_higher_price_if_conversation_rate_is_bigger_than_one(): void
    {
        // Arrange
        Http::fake([
            'purchasing-power-parity.com/*' => Http::response(['ppp' => [
                'pppConversionFactor' => 1.2
            ]]),
        ]);
        $customerLocation = new CustomerLocation($this->getLocationTestData());

        // Act
        $fairPrice = Facades\FairProductPricesFacade::getFairPrice(100, $customerLocation->getCountryCode());

        // Assert
        $this->assertEquals(120, $fairPrice);
    }
}
