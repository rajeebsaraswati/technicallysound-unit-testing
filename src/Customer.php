<?php

namespace Technicallysound\Blog;


class Customer
{
    private bool $isTaxExempted;
    private Address $address;

    /**
     * @param bool $isTaxExempted
     */
    public function setIsTaxExempted(bool $isTaxExempted): void
    {
        $this->isTaxExempted = $isTaxExempted;
    }

    /**
     * @return bool
     */
    public function getIsTaxExempted(): bool
    {
        return $this->isTaxExempted;
    }

    /**
     * @param Address $address
     */
    public function setAddress(Address $address): void
    {
        $this->address = $address;
    }

    /**
     * @return Address
     */
    public function getAddress(): Address
    {
        return $this->address;
    }
}