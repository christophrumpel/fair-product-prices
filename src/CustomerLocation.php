<?php


namespace Christophrumpel\FairProductPrices;


class CustomerLocation
{

    private string $ip;
    private string $country_code;
    private string $country_name;
    private string $region_code;
    private string $region_name;
    private string $city;
    private string $zip_code;
    private string $time_zone;
    private float $latitude;
    private float $longitude;
    private int $metro_code;

    public function __construct(array $locationData)
    {
        $this->ip = $locationData['ip'];
        $this->country_code = $locationData['country_code'];
        $this->country_name = $locationData['country_name'];
        $this->region_code = $locationData['region_code'];
        $this->region_name = $locationData['region_name'];
        $this->city = $locationData['city'];
        $this->zip_code = $locationData['zip_code'];
        $this->time_zone = $locationData['time_zone'];
        $this->latitude = $locationData['latitude'];
        $this->longitude = $locationData['longitude'];
        $this->metro_code = $locationData['metro_code'];
    }

    public function getIp(): string
    {
        return $this->ip;
    }

    public function getCountryCode(): string
    {
        return $this->country_code;
    }

    public function getCountryName(): string
    {
        return $this->country_name;
    }

    public function getRegionCode(): string
    {
        return $this->region_code;
    }

    public function getRegionName(): string
    {
        return $this->region_name;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getZipCode(): string
    {
        return $this->zip_code;
    }

    public function getTimeZone(): string
    {
        return $this->time_zone;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function getMetroCode(): int
    {
        return $this->metro_code;
    }

}
