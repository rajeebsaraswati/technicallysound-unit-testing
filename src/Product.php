<?php

namespace Technicallysound\Blog;


class Product
{
    private int $id;
    private string $sku;
    private float $price;
    private string $taxClass;

    const TAX_CLASS_TAXABLE_GOODS = 'taxable_goods';
    const TAX_CLASS_NON_TAXABLE = 'non_taxable';

    public function __construct(
        int $id,
        string $sku,
        float $price,
        string $taxClass = self::TAX_CLASS_NON_TAXABLE
    ) {
        $this->id = $id;
        $this->sku = $sku;
        $this->price = $price;
        $this->taxClass = $taxClass;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getTaxClass(): string
    {
        return $this->taxClass;
    }

    public function isTaxable(): bool
    {
        return ($this->getTaxClass() === Product::TAX_CLASS_TAXABLE_GOODS);
    }
}
