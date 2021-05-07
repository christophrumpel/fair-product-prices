<?php

namespace Christophrumpel\FairProductPrices\Tests;

use Christophrumpel\FairProductPrices\CustomerLocation;

class CustomerLocationTest extends TestCase
{
    /** @test * */
    public function it_fills_location_and_receives_it_via_getter_methods(): void
    {
        // Arrange
        $customerLocation = new CustomerLocation($this->getLocationTestData());

        // Assert
        $this->assertEquals("11.217.42.113", $customerLocation->getIp());
        $this->assertEquals("AT", $customerLocation->getCountryCode());
        $this->assertEquals("Austria", $customerLocation->getCountryName());
        $this->assertEquals("3", $customerLocation->getRegionCode());
        $this->assertEquals("Vienna", $customerLocation->getRegionName());
        $this->assertEquals("Vienna", $customerLocation->getCity());
        $this->assertEquals("1230", $customerLocation->getZipCode());
        $this->assertEquals("Europe/Vienna", $customerLocation->getTimeZone());
        $this->assertEquals(48.210, $customerLocation->getLatitude());
        $this->assertEquals(16.3634, $customerLocation->getLongitude());
        $this->assertEquals(0, $customerLocation->getMetroCode());
    }

}
