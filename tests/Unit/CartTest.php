<?php

use PHPUnit\Framework\TestCase;
use Technicallysound\Blog;

class CartTest extends TestCase
{
    public function testCalculateTaxReturnsZeroForExemptedCustomers(): void
    {
        $customer = $this->getMockBuilder(Blog\Customer::class)
            ->onlyMethods(['getIsTaxExempted'])
            ->getMock();
        $customer->expects($this->once())
            ->method('getIsTaxExempted')
            ->willReturn(true);

        $cart = new Blog\Cart($customer);

        $result = $cart->calculateTax();
        $this->assertEquals($result, 0);
    }


    public function testCalculateTaxThrowsExceptionIfNoTaxRateIsFoundForTheGivenRegionId(): void
    {
        $customer = $this->getMockBuilder(Blog\Customer::class)
            ->onlyMethods(['getIsTaxExempted', 'getAddress'])
            ->getMock();
        $customer->expects($this->once())
            ->method('getIsTaxExempted')
            ->willReturn(false);

        $address = $this->getMockBuilder(Blog\Address::class)
            ->getMock();
        $address->setRegionId(0);
        $customer->expects($this->once())
            ->method('getAddress')
            ->willReturn($address);

        $this->expectException(Exception::class);

        $this->expectExceptionMessage("No tax rate found for the specified region id!");

        $cart = new Blog\Cart($customer);

        $cart->calculateTax();
    }

    public function testCalculateTaxReturnsZeroIfAllProductsInCartAreNonTaxable(): void
    {
        $address = $this->getMockBuilder(Blog\Address::class)->getMock();
        $address->expects($this->once())->method('getRegionId')->willReturn(1);

        $customer = $this->getMockBuilder(Blog\Customer::class)
            ->onlyMethods(['getIsTaxExempted', 'getAddress'])
            ->getMock();
        $customer->expects($this->once())->method('getIsTaxExempted')->willReturn(false);
        $customer->expects($this->once())->method('getAddress')->willReturn($address);

        $productList = new Blog\ProductList([
            1 => new Blog\Product(1, 'BB01', 90.00, Blog\Product::TAX_CLASS_TAXABLE_GOODS),
            2 => new Blog\Product(2, 'CC01', 40.00, Blog\Product::TAX_CLASS_NON_TAXABLE),
            3 => new Blog\Product(3, 'DD01', 120.00, Blog\Product::TAX_CLASS_NON_TAXABLE),
            4 => new Blog\Product(4, 'AA01', 80.00, Blog\Product::TAX_CLASS_TAXABLE_GOODS)
        ]);

        $cart = new Blog\Cart($customer);
        $cart
//            ->addProduct($productList->getProductById(1))
            ->addProduct($productList->getProductById(2))
            ->addProduct($productList->getProductById(3));
//            ->addProduct($productList->getProductById(4));

        $result = $cart->calculateTax();
        $this->assertEquals($result, 0);
    }

    public function testCalculateTax(): void
    {
        $address = $this->getMockBuilder(Blog\Address::class)->getMock();
        $address->expects($this->once())->method('getRegionId')->willReturn(1);

        $customer = $this->getMockBuilder(Blog\Customer::class)
            ->onlyMethods(['getIsTaxExempted', 'getAddress'])
            ->getMock();
        $customer->expects($this->once())->method('getIsTaxExempted')->willReturn(false);
        $customer->expects($this->once())->method('getAddress')->willReturn($address);

        $productList = new Blog\ProductList([
            1 => new Blog\Product(1, 'BB01', 90.00, Blog\Product::TAX_CLASS_TAXABLE_GOODS),
            2 => new Blog\Product(2, 'CC01', 40.00, Blog\Product::TAX_CLASS_NON_TAXABLE),
            3 => new Blog\Product(3, 'DD01', 120.00, Blog\Product::TAX_CLASS_NON_TAXABLE),
            4 => new Blog\Product(4, 'AA01', 80.00, Blog\Product::TAX_CLASS_TAXABLE_GOODS)
        ]);

        $cart = new Blog\Cart($customer);
        $cart
            ->addProduct($productList->getProductById(1))
            ->addProduct($productList->getProductById(2))
            ->addProduct($productList->getProductById(3))
            ->addProduct($productList->getProductById(4));

        $result = $cart->calculateTax();
        $this->assertGreaterThan(0, $result);
    }
}