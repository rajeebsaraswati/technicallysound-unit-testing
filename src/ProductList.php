<?php

namespace Technicallysound\Blog;

class ProductList
{
    private $list = [];

    public function __construct(array $products = [])
    {
        $this->list = $products ?? [
            1 => new Product(1, 'BB01', 90.00, Product::TAX_CLASS_TAXABLE_GOODS),
            2 => new Product(2, 'CC01', 40.00, Product::TAX_CLASS_NON_TAXABLE),
            3 => new Product(3, 'DD01', 120.00, Product::TAX_CLASS_NON_TAXABLE),
            4 => new Product(4, 'AA01', 80.00, Product::TAX_CLASS_TAXABLE_GOODS)
        ];
    }

    public function getProductById(int $id): Product
    {
        if (!array_key_exists($id, $this->list)) {
            throw new \Exception('No product found with that id!');
        }
        return $this->list[$id];
    }
}