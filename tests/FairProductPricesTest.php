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
}
