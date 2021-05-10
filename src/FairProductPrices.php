<?php

namespace Christophrumpel\FairProductPrices;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class FairProductPrices
{
    public function getCustomerLocation(string $ip): object
    {
        $response = Http::get("https://freegeoip.app/json/{$ip}");

        return new CustomerLocation($response->json());
    }

    public function getFairPrice(float $currentPrice, string $countryCode): float
    {
        $conversionRate = config("fair-product-prices.pppConversionFactor.$countryCode") ?? $this->getConversionRate($countryCode);

        return round($currentPrice * $conversionRate, 2);
    }

    public function getPaddlePayLink(string $paddleProductId, $paddleProductPrices): string
    {
        $response = Http::post('https://vendors.paddle.com/api/2.0/product/generate_pay_link', [
            'vendor_id' => config('fair-product-prices.paddle.vendor_id'),
            'vendor_auth_code' => config('fair-product-prices.paddle.auth_code'),
            'product_id' => $paddleProductId,
            'prices' => $paddleProductPrices,
        ]);
        if (! $response->json()['success']) {
            throw new RuntimeException($response->json()['error']['message']);
        }

        return $response->json()['response']['url'];
    }

    private function getConversionRate(string $countryCode): float
    {
        $response = Http::get("https://api.purchasing-power-parity.com/?target=$countryCode");

        return Arr::get($response->json(), 'ppp.pppConversionFactor');
    }
}
