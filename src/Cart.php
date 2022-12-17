<?php

namespace Technicallysound\Blog;

class Cart
{
    private $items = [];
    private TaxRates $taxRates;
    private Customer $customer;

    private float $subtotal = 0.0;
    private float $taxableSubtotal = 0.0;

    private float $taxRate = 0.0;

    public function __construct(
        Customer $customer
    ) {
        $this->customer = $customer;
        $this->taxRates = new TaxRates();
    }

    public function addProduct(Product $product): Cart
    {
        if (!array_key_exists($product->getId(), $this->items)) {
            $this->items[$product->getId()] = [
                'product' => $product,
                'qty' => 1
            ];
        } else {
            $this->items[$product->getId()]['qty'] += 1;
        }
        return $this;
    }

    private function getTaxableSubtotal(): float
    {
        foreach ($this->items as $item) {
            /** @var $product Product */
            $product = $item['product'];
            // Is the product taxable?
            if ($product->isTaxable()) {
                $this->taxableSubtotal += ($product->getPrice() * $item['qty']);
            }
            $this->subtotal += ($product->getPrice() * $item['qty']);
        }
        return $this->taxableSubtotal;
    }

    public function calculateTax(): float
    {
        // check if customer is exempted from tax
        if ($this->customer->getIsTaxExempted()) {
            return 0.0; // return 0 and terminate
        } else {
            // get customer address and region id from the address
            $regionId = $this->customer->getAddress()->getRegionId();
            // get tax rate for the region id
            $this->taxRate = $this->taxRates->getTaxRate($regionId);
            // Get taxable subtotal
            $taxableSubtotal = $this->getTaxableSubtotal();
            // then calculate tax
            $tax = ($taxableSubtotal * $this->taxRate) / 100;
            return $tax;
        }
    }

    public function getCartSummary(): array
    {
        $tax = $this->calculateTax();
        return [
            'items' => $this->items,
            'subtotal' => $this->subtotal,
            'taxableSubtotal' => $this->taxableSubtotal,
            'taxRate' => $this->taxRate,
            'tax' => $tax,
            'payble' => $this->subtotal + $tax
        ];
    }
}