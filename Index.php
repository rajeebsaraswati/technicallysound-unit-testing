<?php

require './vendor/autoload.php';

use Technicallysound\Blog;


$productList = new Blog\ProductList();

$cart1 = new Blog\Cart(
    new Blog\Customer(false, new Blog\Address('US', 1))
);
$cart1->addProduct($productList->getProductById(1))
    ->addProduct($productList->getProductById(1))
    ->addProduct($productList->getProductById(2))
    ->addProduct($productList->getProductById(2))
    ->addProduct($productList->getProductById(2));

$summary = $cart1->getCartSummary();

print_r($summary);