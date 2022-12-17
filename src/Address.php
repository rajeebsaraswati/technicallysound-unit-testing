<?php

namespace Technicallysound\Blog;

class Address
{
    private string $countryId;
    private int $regionId;

    /**
     * @return string
     */
    public function getCountryId(): string
    {
        return $this->countryId;
    }

    /**
     * @param string $countryId
     */
    public function setCountryId(string $countryId): void
    {
        $this->countryId = $countryId;
    }

    /**
     * @return int
     */
    public function getRegionId(): int
    {
        return $this->regionId;
    }

    /**
     * @param int $regionId
     */
    public function setRegionId(int $regionId): void
    {
        $this->regionId = $regionId;
    }
}
