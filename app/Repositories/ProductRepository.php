<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    private Product $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function create(array $data)
    {
        return $this->product->create($data);
    }

    public function getAll()
    {
        return $this->product->all();
    }
}
