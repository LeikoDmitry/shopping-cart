<?php

namespace App\Repository;

use App\Model\Product;

interface CartRepositoryInterface
{
    public function add(Product $product, $count);

    public function update(Product $product, $quantity);

    public function has(Product $product);
}