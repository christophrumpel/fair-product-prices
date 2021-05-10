<?php

namespace Christophrumpel\FairProductPrices\Tests;

use Christophrumpel\FairProductPrices\CustomerLocation;
use Christophrumpel\FairProductPrices\Facades;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class FairProductPricesTest extends TestCase
{
    /** @test * */
    public function it_gets_customers_location_through_IP(): void
    {
        // Arrange
        Http::fake([
            'freegeoip.app/*' => Http::response($this->getLocationTestData()),
        ]);

        // Act
        $customerLocation = Facades\FairProductPrices::getCustomerLocation('11.111.11.113');

        // Assert
        $this->assertInstanceOf(CustomerLocation::class, $customerLocation);
        $this->assertEquals('AT', $customerLocation->getCountryCode());
    }

    /** @test * */
    public function it_gets_fair_price_for_given_customer_location(): void
    {
        // Arrange
        Http::fake([
            'purchasing-power-parity.com/*' => Http::response([
                'ppp' => [
                    'pppConversionFactor' => 0.9
                ]
            ]),
        ]);
        $customerLocation = new CustomerLocation($this->getLocationTestData());

        // Act
        $fairPrice = Facades\FairProductPrices::getFairPrice(100, $customerLocation->getCountryCode());

        // Assert
        $this->assertEquals(90, $fairPrice);
    }

    /** @test * */
    public function it_rounds_fair_prices_for_given_customer_location(): void
    {
        // Arrange
        Http::fake([
            'purchasing-power-parity.com/*' => Http::response([
                'ppp' => [
                    'pppConversionFactor' => 0.874636277820489
                ]
            ]),
        ]);
        $customerLocation = new CustomerLocation($this->getLocationTestData());

        // Act
        $fairPrice = Facades\FairProductPrices::getFairPrice(99.99, $customerLocation->getCountryCode());

        // Assert
        $this->assertEquals(87.45, $fairPrice);
    }

    /** @test * */
    public function it_calculates_a_higher_price_if_conversation_rate_is_bigger_than_one(): void
    {
        // Arrange
        Http::fake([
            'purchasing-power-parity.com/*' => Http::response([
                'ppp' => [
                    'pppConversionFactor' => 1.2
                ]
            ]),
        ]);
        $customerLocation = new CustomerLocation($this->getLocationTestData());

        // Act
        $fairPrice = Facades\FairProductPrices::getFairPrice(100, $customerLocation->getCountryCode());

        // Assert
        $this->assertEquals(120, $fairPrice);
    }

    /** @test * */
    public function it_uses_custom_conversion_factor_if_defines(): void
    {
        // Arrange
        Http::fake([
            'purchasing-power-parity.com/*' => Http::response([
                'ppp' => [
                    'pppConversionFactor' => 0.9
                ]
            ]),
        ]);
        $customerLocation = new CustomerLocation($this->getLocationTestData(['country_code' => 'DE']));
        Config::set('fair-product-prices.pppConversionFactor', ['DE' => 0.8]);

        // Act
        $fairPrice = Facades\FairProductPrices::getFairPrice(100, $customerLocation->getCountryCode());

        // Assert
        $this->assertEquals(80, $fairPrice);
    }

    /** @test * */
    public function it_creates_paddle_pay_link_for_price(): void
    {
        // Arrange
        Http::fake([
            'https://vendors.paddle.com/api/2.0/*' => Http::response([
                "success" => true,
                "response" => [
                    "url" => "https://checkout.paddle.com/checkout/custom/dskfkdsfds"
                ]
            ]),
        ]);

        // Act
        $fairPrice = Facades\FairProductPrices::getPaddlePayLink(1234, ['EUR:19.99']);

        // Assert
        $this->assertStringContainsString('https://checkout.paddle.com/checkout/custom', $fairPrice);
    }

    /** @test * */
    public function it_throws_exception_if_credentials_are_wrong(): void
    {
        Http::fake([
            'https://vendors.paddle.com/api/2.0/*' => Http::response([
                "success" => false,
                "error" => [
                    'message' => "You don't have permission to access this resource",
                ]
            ]),
        ]);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("You don't have permission to access this resource");

        // Act
        Facades\FairProductPrices::getPaddlePayLink(1234, ['EUR:19.99']);

        $this->assertTrue(false);
    }
}
