<?php

namespace Technicallysound\Blog;

class TaxRates
{
    private $rates = [
        // 'region_id' => 'tax percentage value'
        1 => 12.0,
        2 => 11.6,
        3 => 20.5
    ];

    /**
     * @throws \Exception
     */
    public function getTaxRate(int $regionId): float
    {
        if (!array_key_exists($regionId, $this->rates)) {
            throw new \Exception("No tax rate found for the specified region id!");
        }
        return $this->rates[$regionId];
    }
}