<?php

namespace Christophrumpel\FairProductPrices;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class FairProductPrices
{
    public function getLocation(string $ip): object
    {
        $response = Http::get("https://freegeoip.app/json/{$ip}");

        return new CustomerLocation($response->json());
    }

    public function getFairPrice(float $currentPrice, string $countryCode): float
    {
        $response = Http::get("https://api.purchasing-power-parity.com/?target=$countryCode");

        $conversionRate = Arr::get($response->json(), 'ppp.pppConversionFactor');

        return round($currentPrice * $conversionRate, 2);
    }
}
