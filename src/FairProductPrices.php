<?php

namespace Christophrumpel\FairProductPrices;

use Illuminate\Support\Facades\Http;

class FairProductPrices
{
    public function getLocation(string $ip): object
    {
        $response = Http::get("https://freegeoip.app/json/{$ip}");

        return new CustomerLocation($response->json());
    }
}
